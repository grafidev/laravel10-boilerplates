<?php

namespace App\SearchAspects;

use App\Repositories\PurchaseOrderRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class PurchaseOrderSearchAspect extends SearchAspect
{
    public function __construct(private PurchaseOrderRepository $purchaseOrderRepository)
    {
    }

    public function getResults(string $term): Collection
    {
        return $this->purchaseOrderRepository->query()->search(['search' => $term])->get();
    }
}
