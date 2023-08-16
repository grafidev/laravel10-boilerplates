<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionCancellationRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Services\TransactionCancellationService;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionCancellationAPIController extends Controller
{
    use ApiResponse;

    public function __construct(
        private TransactionRepository $transactionRepository,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(TransactionCancellationRequest $request, int $id)
    {
        DB::transaction(function () use ($request, $id) {
            /** @var Transaction $transaction */
            $transaction = $this->transactionRepository->find($id);

            try {
                $data = TransactionCancellationService::handle($transaction, $request->validated('cancellation_reason'));

                if (! $data['success']) {
                    return $this->sendError($data['message'], $data['status']);
                }

                return $this->sendResponse($data['message']);
            } catch (Exception $e) {
                return $this->sendError($e->getMessage());
            }
        });
    }
}
