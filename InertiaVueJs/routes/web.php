<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SearchController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', DashboardController::class)->name('dashboard')->middleware('auth', 'verified');

Route::middleware('auth', 'verified', 'password.expired')->group(function () {
    Route::namespace(\App\Http\Controllers\Dashboard::class)
        ->prefix('/dashboard')
        ->as('dashboard.')
        ->group(function () {
            Route::resource('users', UsersController::class);
            Route::resource('roles', RolesController::class)->except('show', 'destroy'); // ->middleware('can:super_admin');
            Route::resource('permissions', PermissionsController::class)->only('index', 'store', 'update')->middleware('can:super_admin');
            Route::get('/search/{search}', [SearchController::class, 'index'])->name('search.index');
            Route::resource('user-exporters', UsersExporterController::class)->only('index')->middleware('can:super_admin');
            Route::post('notifications/readAll', [\App\Http\Controllers\Dashboard\NotificationsController::class, 'readAll'])->name('notifications.readAll');
        });
});

Route::middleware('auth')->prefix('/dashboard')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('user/new-password/{id?}/{token?}', [NewPasswordController::class, 'edit'])->name('new-password.edit');
Route::put('user/new-password/{id}/{token}', [NewPasswordController::class, 'update'])->name('new-password.update');

require __DIR__.'/auth.php';
