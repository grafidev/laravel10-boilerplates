<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\API\Traits\RespondWithToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSessionRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Services\AuthenticatorApiService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use RespondWithToken;
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(CreateSessionRequest $request, UserRepository $userRepository): JsonResponse
    {
        $token = (new AuthenticatorApiService($userRepository))->handle($request->validated());

        if ($token === null) {
            return $this->notAuthorized();
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        return response()->json(UserResource::make(auth('api')->user()));
    }

    public function logout(): JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }
}
