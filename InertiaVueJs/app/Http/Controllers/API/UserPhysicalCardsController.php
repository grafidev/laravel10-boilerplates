<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PhysicalCardResource;
use Illuminate\Http\Request;

class UserPhysicalCardsController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request)
    {
        $physicalCards = $request->user()->physicalCardsAssignment()->enabled()->get();

        $message = count($physicalCards) > 0 ? 'Station manager physical cards found successfully :)' : 'No physical cards found :(';

        return $this->sendData(data: PhysicalCardResource::collection($physicalCards), message: $message);
    }
}
