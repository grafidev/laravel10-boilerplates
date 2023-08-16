<?php

namespace App\SearchAspects;

use App\Repositories\StationRepository;
use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class StationSearchAspect extends SearchAspect
{
    public function __construct(private StationRepository $stationRepository)
    {
    }

    public function getResults(string $term): Collection
    {
        return $this->stationRepository->query()->search(['search' => $term])->get();
    }

    public function getType(): string
    {
        return 'Stations';
    }
}
