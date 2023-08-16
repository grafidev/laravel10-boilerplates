<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\AppSetting;

class AppSettingsController extends Controller
{
    use ApiResponse;

    public function __invoke(int $country_id, int $company_id)
    {
        $appSetting = AppSetting::query()
            ->where('country_id', $country_id)
            ->where('company_id', $company_id)
            ->first();

        if ($appSetting !== null) {
            return $this->sendData($appSetting, 'Settings retrieved successfully :)');
        }

        return $this->sendError('Not found', 404);
    }
}
