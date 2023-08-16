<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FidelityPointResource;
use App\Repositories\FidelityPointRepository;
use Illuminate\Http\Request;

class FidelityPointsController extends Controller
{
    use ApiResponse;

    public function __construct(private FidelityPointRepository $fidelityPointRepository)
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $fidelityPoints = $this->fidelityPointRepository
            ->query()
            ->where('country_id', $request->user()->country_id)
            ->enabled()
            ->get();

        return $this->sendResponse(count($fidelityPoints) > 0 ? 'List of fidelity points' : 'No fidelity points found', FidelityPointResource::collection($fidelityPoints));
    }
}
