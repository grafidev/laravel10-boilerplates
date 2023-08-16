<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementResource;
use App\Repositories\AdvertisementRepository;
use Illuminate\Http\Request;

class UserAdvertisementsController extends Controller
{
    use ApiResponse;

    public function __construct(private AdvertisementRepository $advertisementRepository)
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $advertisements = $this->advertisementRepository
            ->query()
            ->where('country_id', $request->user()->country_id)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();

        return $this->sendResponse('User Advertisements retrieved successfully :)', AdvertisementResource::collection($advertisements));
    }
}
