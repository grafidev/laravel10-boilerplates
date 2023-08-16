<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionTypeResource;
use App\Repositories\TransactionTypeRepository;

class TransactionTypesController extends Controller
{
    use ApiResponse;

    public function __construct(private TransactionTypeRepository $transactionTypeRepository)
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $transactionTypes = $this->transactionTypeRepository
            ->query()
            ->enabled()
            ->get();

        return $this->sendResponse('List of transaction types', TransactionTypeResource::collection($transactionTypes));
    }
}
