<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserBalanceController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show(Request $request)
    {
        return $this->json([
            'balance' => $request->user()?->wallet?->balance ?? 0,
        ]);
    }
}
