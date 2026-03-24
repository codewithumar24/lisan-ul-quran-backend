<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Core\Http\Controllers\PermissionController;
use Modules\Core\Http\Controllers\RoleController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('cores', CoreController::class)->names('core');
});
Route::prefix('core')->group(function () {
    // Role routes
    Route::apiResource('roles', RoleController::class);

    // Permission routes
    Route::get('permissions/groups', [PermissionController::class, 'groups']);
    Route::apiResource('permissions', PermissionController::class);
});
