<?php

namespace App\SearchAspects;

use App\Repositories\TransactionRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class TransactionSearchAspect extends SearchAspect
{
    public function __construct(private TransactionRepository $transactionRepository)
    {
    }

    public function getResults(string $term): Collection
    {
        return $this->transactionRepository->query()->search(['search' => $term])->get();
    }

    public function getType(): string
    {
        return 'Transactions';
    }
}
