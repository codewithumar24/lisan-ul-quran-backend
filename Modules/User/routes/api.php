<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Auth\AuthController;
use Modules\User\Http\Controllers\Auth\GoogleAuthController;
use Modules\User\Http\Controllers\UserController;

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    // Google OAuth
    Route::get('google/redirect', [GoogleAuthController::class, 'redirect']);
    Route::get('google/callback', [GoogleAuthController::class, 'callback']);
});

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::get('me', [AuthController::class, 'me']);
    });

    // User management (admin only)
    Route::middleware('permission:View Users')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});

Route::middleware(['auth:sanctum', 'permission:Create Users'])->post('users/admin-create', [UserController::class, 'adminCreate']);
