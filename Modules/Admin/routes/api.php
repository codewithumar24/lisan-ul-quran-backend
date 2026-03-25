<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;


use Modules\Admin\Http\Controllers\ArabicLetterController;
use Modules\Admin\Http\Controllers\TajweedRuleController;

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

    Route::prefix('makhraj-categories')->group(function () {
        Route::get('/', [MakhrajCategoryController::class, 'index'])
            ->middleware('permission:View Makhraj Categories');

        Route::post('/', [MakhrajCategoryController::class, 'store'])
            ->middleware('permission:Create Makhraj Categories');

        Route::post('update-order', [MakhrajCategoryController::class, 'updateDisplayOrder'])
            ->middleware('permission:Update Makhraj Categories');

        Route::get('{uuid}', [MakhrajCategoryController::class, 'show'])
            ->middleware('permission:View Makhraj Categories');

        Route::put('{uuid}', [MakhrajCategoryController::class, 'update'])
            ->middleware('permission:Update Makhraj Categories');

        Route::delete('{uuid}', [MakhrajCategoryController::class, 'destroy'])
            ->middleware('permission:Delete Makhraj Categories');
    });

    // Tajweed Rules routes
    Route::prefix('tajweed-rules')->group(function () {
        Route::get('/', [TajweedRuleController::class, 'index'])
            ->middleware('permission:View Tajweed Rules');

        Route::get('categories', [TajweedRuleController::class, 'getCategories'])
            ->middleware('permission:View Tajweed Rules');

        Route::get('by-category/{category}', [TajweedRuleController::class, 'getByCategory'])
            ->middleware('permission:View Tajweed Rules');

        Route::post('/', [TajweedRuleController::class, 'store'])
            ->middleware('permission:Create Tajweed Rules');

        Route::post('update-order', [TajweedRuleController::class, 'updateDisplayOrder'])
            ->middleware('permission:Update Tajweed Rules');

        Route::get('{uuid}', [TajweedRuleController::class, 'show'])
            ->middleware('permission:View Tajweed Rules');

        Route::put('{uuid}', [TajweedRuleController::class, 'update'])
            ->middleware('permission:Update Tajweed Rules');

        Route::delete('{uuid}', [TajweedRuleController::class, 'destroy'])
            ->middleware('permission:Delete Tajweed Rules');
    });
});

