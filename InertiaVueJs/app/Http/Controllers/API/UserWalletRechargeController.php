<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserWalletRechargeRequest;
use App\Repositories\UserRepository;

class UserWalletRechargeController extends Controller
{
    use ApiResponse;

    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function store(UserWalletRechargeRequest $request, UserRepository $userRepository)
    {
        /** @var \App\Models\User $user */
        $user = $userRepository->findByPhoneNumber($request->phone_number);

        try {
            $user->updateWalletBalance($request->amount);

            return $this->sendResponse('Balance updated :)');
        } catch (\Exception $e) {
            return $this->sendBadResponse($e->getMessage());
        }
    }
}
