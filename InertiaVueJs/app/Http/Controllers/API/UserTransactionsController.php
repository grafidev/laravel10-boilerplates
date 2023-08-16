<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\TransactionType;
use App\Models\User;
use App\Repositories\TransactionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserTransactionsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request, TransactionRepository $transactionRepository): JsonResponse
    {
        if (! in_array($request->transaction_type, [TransactionType::ACHAT, TransactionType::RECHARGE])) {
            return $this->sendBadResponse("Transaction type: {$request->transaction_type} does not exist");
        }

        /** @var User $user */
        $user = $request->user();

        $transactions = $transactionRepository->query()
            ->with('transaction_type')
            ->whereRelation('transaction_type', 'slug', $request->transaction_type)
            ->where(fn ($query) => $query->where('sender_id', $user->id)->orWhere('receiver_id', $user->id))
            ->get();

        return $this->sendResponse(
            'User transactions for transaction type of '.$request->transaction_type,
            TransactionResource::collection($transactions),
        );
    }
}
