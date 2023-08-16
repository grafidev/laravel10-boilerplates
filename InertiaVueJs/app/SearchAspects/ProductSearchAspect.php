<?php

namespace App\SearchAspects;

use Illuminate\Support\Collection;
use Spatie\Searchable\SearchAspect;

class ProductSearchAspect extends SearchAspect
{
    public function getResults(string $term): Collection
    {
        return authUser()->products()->search(['search' => $term])->get();
    }

    public function getType(): string
    {
        return 'Produits';
    }
}
