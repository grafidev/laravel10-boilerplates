<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\QrCodeDecrypterRequest;
use App\Services\QrCodeDecrypterService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class QrCodeDecrypterController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function __invoke(QrCodeDecrypterRequest $request): JsonResponse
    {
        try {
            $qrCodeValue = $request->validated('qrcode_value');

            $decryptedQrCodeValue = Crypt::decryptString($qrCodeValue);

            return QrCodeDecrypterService::make()->handle($decryptedQrCodeValue);
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
    }
}
