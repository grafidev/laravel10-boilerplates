<?php

namespace App\SearchAspects;

use App\Repositories\PhysicalCardRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class PhysicalCardSearchAspect extends SearchAspect
{
    public function __construct(private PhysicalCardRepository $physicalCardRepository)
    {
    }

    public function getType(): string
    {
        return 'Cartes';
    }

    public function getResults(string $term): Collection
    {
        return $this->physicalCardRepository->query()->search(['search' => $term])->get();
    }
}
