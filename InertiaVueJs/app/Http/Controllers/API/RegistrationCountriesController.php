<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountriesForRegistrationResource;
use App\Models\Role;
use App\Repositories\CountryRepository;
use Illuminate\Database\Eloquent\Builder;

class RegistrationCountriesController extends Controller
{
    use ApiResponse;

    public function __construct(private CountryRepository $countryRepository)
    {
    }

    public function index()
    {
        $countries = $this->countryRepository
            ->query()
            ->enabled()
            ->whereHas('clients', fn (Builder $query) => $query->role(Role::ADMIN))
            ->orderBy('countries.name')
            ->get();

        return $this->sendResponse('List of available countries', CountriesForRegistrationResource::collection($countries));
    }
}
