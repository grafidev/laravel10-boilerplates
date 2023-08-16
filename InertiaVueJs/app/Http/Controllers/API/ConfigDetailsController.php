<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use App\Repositories\ConfigRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ConfigDetailsController extends Controller
{
    use ApiResponse;

    public function __construct(private ConfigRepository $configRepository, private CompanyRepository $companyRepository, private UserRepository $userRepository)
    {
        $this->middleware('auth:api');
    }

    public function show(int $countryId, int $companyId, Request $request)
    {
        if ($request->user()->country_id != $countryId || ! $request->user()->companies->contains($companyId)) {
            return $this->sendError('Forbidden', 403);
        }

        $config = $this->configRepository
            ->query()
            ->where(['country_id' => $countryId, 'company_id' => $companyId])
            ->get()
            ->reduce(
                fn ($acc, $config) => $acc + [$config->name => $config->value],
                [],
            );

        return $this->sendResponse('Config details', $config);
    }
}
