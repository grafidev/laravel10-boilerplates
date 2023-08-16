<?php

namespace App\SearchAspects;

use App\Repositories\CorporateClientRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class CorporateClientSearchAspect extends SearchAspect
{
    public function __construct(private CorporateClientRepository $corporateClientRepository)
    {
    }

    public function getResults(string $term): Collection
    {
        return $this->corporateClientRepository->query()->search(['search' => $term])->get();
    }

    public function getType(): string
    {
        return 'Entreprises';
    }
}
