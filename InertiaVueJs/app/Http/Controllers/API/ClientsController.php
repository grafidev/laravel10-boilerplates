<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\API\Traits\RespondWithToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAccountRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;

class ClientsController extends Controller
{
    use RespondWithToken;
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api', ['only' => 'show']);
    }

    public function show()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function store(CreateAccountRequest $request, UserRepository $userRepository)
    {
        try {
            $userRepository->createClient($request->validated());

            return $this->sendResponse(message: 'Account created successfully :)', code: Response::HTTP_CREATED);
        } catch (Exception $e) {
            return $this->sendResponse(message: 'Failed to create user account: '.$e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
