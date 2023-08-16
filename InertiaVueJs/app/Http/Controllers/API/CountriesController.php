<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Repositories\CountryRepository;

class CountriesController extends Controller
{
    use ApiResponse;

    public function __construct(private CountryRepository $countryRepository)
    {
        $this->middleware('auth:api')->except('show');
    }

    public function index()
    {
        $countries = $this->countryRepository->enabled()->orderBy('name')->get();

        return $this->sendResponse('List of countries', CountryResource::collection($countries));
    }

    public function show($id)
    {
        $query = $this->countryRepository->enabled();

        $country = match (true) {
            preg_match('/^[a-zA-Z]*$/', $id) === 1 => $query->where('code', $id)->first(),
            preg_match('/^[0-9]*$/', $id) === 1 => $query->find($id),
            default => $query->find($id),
        };

        if ($country === null) {
            return $this->sendResponse(message: 'Le pays ne semble pas exister dans le système.', code: 404);
        }

        return $this->sendResponse('Country retrieved successfully :)', CountryResource::make($country));
    }
}
