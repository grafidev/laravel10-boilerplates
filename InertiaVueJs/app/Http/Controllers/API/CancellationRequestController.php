<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancellationRequestFormRequest;
use App\Repositories\CancellationRequestRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Response;

class CancellationRequestController extends Controller
{
    use ApiResponse;

    public function __construct(
        private CancellationRequestRepository $cancellationRequestRepository,
        private TransactionRepository $transactionRepository,
    ) {
        $this->middleware('auth:api');
    }

    public function store(CancellationRequestFormRequest $request)
    {
        /** @var \App\Models\Transaction $transaction */
        $transaction = $this->transactionRepository->find($request->validated('transaction_id'));

        if (! $transaction->isCancellable()) {
            return $this->sendError('Cette transaction ne peut être annulée.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cancellationAlreadyRequested = $this->cancellationRequestRepository
            ->query()
            ->where('user_id', $request->user()->id)
            ->where('transaction_id', $request->validated('transaction_id'))
            ->exists();

        if ($cancellationAlreadyRequested) {
            return $this->sendError(
                "Vous avez déjà initié une demande d'annulation pour cette transaction",
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->cancellationRequestRepository->create([...$request->validated(), 'user_id' => $request->user()->id]);

        return $this->sendData(message: 'Cancellation request initiated :)');
    }
}
