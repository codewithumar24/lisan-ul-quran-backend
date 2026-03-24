<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;


use Modules\Admin\Http\Controllers\ArabicLetterController;

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Arabic Letters routes with permissions
    Route::prefix('arabic-letters')->group(function () {
        Route::get('/', [ArabicLetterController::class, 'index'])
            ->middleware('permission:View Arabic Letters');
        
        Route::get('makhraj-categories', [ArabicLetterController::class, 'getMakhrajCategories'])
            ->middleware('permission:View Arabic Letters');
        
        Route::get('by-category/{category}', [ArabicLetterController::class, 'getByMakhrajCategory'])
            ->middleware('permission:View Arabic Letters');
        
        Route::post('/', [ArabicLetterController::class, 'store'])
            ->middleware('permission:Create Arabic Letters');
        
        Route::post('update-order', [ArabicLetterController::class, 'updateDisplayOrder'])
            ->middleware('permission:Update Arabic Letters');
        
        Route::get('{uuid}', [ArabicLetterController::class, 'show'])
            ->middleware('permission:View Arabic Letters');
        
        Route::put('{uuid}', [ArabicLetterController::class, 'update'])
            ->middleware('permission:Update Arabic Letters');
        
        Route::delete('{uuid}', [ArabicLetterController::class, 'destroy'])
            ->middleware('permission:Delete Arabic Letters');
    });
});

