<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTransactionRequest;
use App\Repositories\FidelityPointsSettingsRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class WalletTransactionsController extends Controller
{
    use ApiResponse;

    public function __construct(private FidelityPointsSettingsRepository $fidelityPointsSettingsRepository)
    {
        $this->middleware('auth:api');
    }

    public function store(
        TransactionRepository $transactionRepository,
        CreateTransactionRequest $request,
        UserRepository $userRepository,
    ) {
        $data = $request->validated();
        $sender = $userRepository->findByPhoneNumber($data['sender_phone_number']);
        $receiver = $userRepository->findByPhoneNumber($data['receiver_phone_number']);

        if ($sender->isNotAuthorizedToSend($receiver)) {
            return $this->sendForbiddenResponse("La transaction entre les deux comptes n'est pas permise.");
        }

        if (! $sender->inTheSameCountryOf($receiver)) {
            return $this->sendForbiddenResponse('Zone error');
        }

        $transaction = $transactionRepository->initiate($data, $sender, $receiver);

        try {
            DB::transaction(function () use ($sender, $receiver, $transaction) {
                $sender->transfer($receiver, $transaction->amount);
                $transaction->applyFidelityPoints();
                // $transaction->calculateLitersCount();
                $transaction->succeeded();
            });

            return $this->sendCreatedResponse('Transaction successfully created');
        } catch (\Exception $e) {
            $transaction->forceFill(['amount' => 0, 'liters_count' => 0]);
            $transaction->failed($e->getMessage());

            return $this->sendBadResponse($e->getMessage());
        } finally {
            $transaction->save();
        }
    }
}
