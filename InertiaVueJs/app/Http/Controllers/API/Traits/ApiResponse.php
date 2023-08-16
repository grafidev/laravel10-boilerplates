<?php

namespace App\Http\Controllers\API\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    public function json($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    public function sendData($data = [], $message = null, $code = 200)
    {
        return response()->json(['success' => true, 'data' => $data, 'message' => $message], $code);
    }

    public function sendResponse($message, $data = [], $code = 200)
    {
        return response()->json(['data' => $data, 'message' => $message], $code);
    }

    public function sendError($message, $code = 500)
    {
        return response()->json(['success' => false, 'data' => [], 'message' => $message], $code);
    }

    public function sendForbiddenResponse(string $message): JsonResponse
    {
        return $this->sendResponse($message, Response::HTTP_FORBIDDEN);
    }

    public function sendBadResponse(string $message): JsonResponse
    {
        return $this->sendResponse($message, Response::HTTP_BAD_REQUEST);
    }

    public function sendCreatedResponse(string $message)
    {
        return $this->sendResponse($message, Response::HTTP_CREATED);
    }

    public function notAuthorized()
    {
        return $this->sendResponse('Unauthorized', ['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }
}
