<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ClientsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('clients', ClientsController::class)->only('store', 'show');

Route::middleware('api')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
