<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\SearchAspects\CorporateClientSearchAspect;
use App\SearchAspects\PhysicalCardSearchAspect;
use App\SearchAspects\ProductSearchAspect;
use App\SearchAspects\PurchaseOrderSearchAspect;
use App\SearchAspects\RoleSearchAspect;
use App\SearchAspects\StationSearchAspect;
use App\SearchAspects\TransactionSearchAspect;
use App\SearchAspects\UserSearchAspect;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function index(string $search)
    {
        $searchResults = (new Search())
            ->registerAspect(UserSearchAspect::class)
            ->registerAspect(TransactionSearchAspect::class)
            ->registerAspect(CorporateClientSearchAspect::class)
            ->registerAspect(StationSearchAspect::class)
            ->registerAspect(ProductSearchAspect::class)
            ->registerAspect(PurchaseOrderSearchAspect::class)
            ->registerAspect(PhysicalCardSearchAspect::class)
            ->registerAspect(RoleSearchAspect::class)
            ->search($search);

        return response()->json($searchResults->groupByType());
    }
}
