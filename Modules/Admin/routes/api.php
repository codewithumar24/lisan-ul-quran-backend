<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\AdminController;


use Modules\Admin\Http\Controllers\ArabicLetterController;
use Modules\Admin\Http\Controllers\LessonController;
use Modules\Admin\Http\Controllers\MakhrajCategoryController;
use Modules\Admin\Http\Controllers\PracticeExerciseController;
use Modules\Admin\Http\Controllers\QuizController;
use Modules\Admin\Http\Controllers\QuizQuestionController;
use Modules\Admin\Http\Controllers\TajweedRuleController;
use Modules\User\Http\Controllers\Auth\AuthController;
use Modules\User\Http\Controllers\UserController;

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::post('users/admin-create', [UserController::class, 'adminCreate']);

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });

    Route::prefix('arabic-letters')->group(function () {
        Route::get('/', [ArabicLetterController::class, 'index']);
        Route::get('makhraj-categories', [ArabicLetterController::class, 'getMakhrajCategories']);
        Route::get('by-category/{category}', [ArabicLetterController::class, 'getByMakhrajCategory']);
        Route::post('/', [ArabicLetterController::class, 'store']);
        Route::post('update-order', [ArabicLetterController::class, 'updateDisplayOrder']);
        Route::get('{uuid}', [ArabicLetterController::class, 'show']);
        Route::put('{uuid}', [ArabicLetterController::class, 'update']);
        Route::delete('{uuid}', [ArabicLetterController::class, 'destroy']);
    });

    Route::prefix('makhraj-categories')->group(function () {
        Route::get('/', [MakhrajCategoryController::class, 'index']);
        Route::post('/', [MakhrajCategoryController::class, 'store']);
        Route::post('update-order', [MakhrajCategoryController::class, 'updateDisplayOrder']);
        Route::get('{uuid}', [MakhrajCategoryController::class, 'show']);
        Route::put('{uuid}', [MakhrajCategoryController::class, 'update']);
        Route::delete('{uuid}', [MakhrajCategoryController::class, 'destroy']);
    });

    // Tajweed Rules routes
    Route::prefix('tajweed-rules')->group(function () {
        Route::get('/', [TajweedRuleController::class, 'index']);
        Route::get('categories', [TajweedRuleController::class, 'getCategories']);
        Route::get('by-category/{category}', [TajweedRuleController::class, 'getByCategory']);
        Route::post('/', [TajweedRuleController::class, 'store']);
        Route::post('update-order', [TajweedRuleController::class, 'updateDisplayOrder']);
        Route::get('{uuid}', [TajweedRuleController::class, 'show']);
        Route::put('{uuid}', [TajweedRuleController::class, 'update']);
        Route::delete('{uuid}', [TajweedRuleController::class, 'destroy']);
    });

    // Lesson routes
    Route::prefix('lessons')->group(function () {
        Route::get('/', [LessonController::class, 'index']);
        Route::get('types', [LessonController::class, 'getLessonTypes']);
        Route::get('published', [LessonController::class, 'getPublished']);
        Route::get('by-chapter/{chapterNumber}', [LessonController::class, 'getByChapter']);
        Route::get('next-number/{chapterNumber}', [LessonController::class, 'getNextLessonNumber']);
        Route::post('/', [LessonController::class, 'store']);
        Route::post('update-order', [LessonController::class, 'updateOrder']);
        Route::get('{uuid}', [LessonController::class, 'show']);
        Route::put('{uuid}', [LessonController::class, 'update']);
        Route::delete('{uuid}', [LessonController::class, 'destroy']);
        Route::post('{uuid}/publish', [LessonController::class, 'publish']);
        Route::post('{uuid}/unpublish', [LessonController::class, 'unpublish']);
    });

    // Practice Exercises routes
    Route::prefix('practice-exercises')->group(function () {
        Route::get('/', [PracticeExerciseController::class, 'index']);
        Route::get('types', [PracticeExerciseController::class, 'getExerciseTypes']);
        Route::get('by-lesson/{lessonId}', [PracticeExerciseController::class, 'getByLesson']);
        Route::get('next-order/{lessonId}', [PracticeExerciseController::class, 'getNextDisplayOrder']);
        Route::post('/', [PracticeExerciseController::class, 'store']);
        Route::post('update-order/{lessonId}', [PracticeExerciseController::class, 'updateDisplayOrder']);
        Route::get('{uuid}', [PracticeExerciseController::class, 'show']);
        Route::put('{uuid}', [PracticeExerciseController::class, 'update']);
        Route::delete('{uuid}', [PracticeExerciseController::class, 'destroy']);
    });

    // Quizzes routes
    Route::prefix('quizzes')->group(function () {
        Route::get('/', [QuizController::class, 'index']);
        Route::get('types', [QuizController::class, 'getQuizTypes']);
        Route::get('by-lesson/{lessonId}', [QuizController::class, 'getByLesson']);
        Route::get('by-chapter/{chapterNumber}', [QuizController::class, 'getByChapter']);
        Route::get('next-order', [QuizController::class, 'getNextDisplayOrder']);
        Route::post('/', [QuizController::class, 'store']);
        Route::post('update-order', [QuizController::class, 'updateDisplayOrder']);
        Route::get('{uuid}', [QuizController::class, 'show']);
        Route::put('{uuid}', [QuizController::class, 'update']);
        Route::delete('{uuid}', [QuizController::class, 'destroy']);
        Route::post('{uuid}/publish', [QuizController::class, 'publish']);
        Route::post('{uuid}/unpublish', [QuizController::class, 'unpublish']);
    });

    // Quiz Questions routes
    Route::prefix('quiz-questions')->group(function () {
        Route::get('types', [QuizQuestionController::class, 'getQuestionTypes']);
        Route::get('by-quiz/{quizId}', [QuizQuestionController::class, 'getByQuiz']);
        Route::get('next-order/{quizId}', [QuizQuestionController::class, 'getNextDisplayOrder']);
        Route::post('/', [QuizQuestionController::class, 'store']);
        Route::post('update-order/{quizId}', [QuizQuestionController::class, 'updateDisplayOrder']);
        Route::get('{uuid}', [QuizQuestionController::class, 'show']);
        Route::put('{uuid}', [QuizQuestionController::class, 'update']);
        Route::delete('{uuid}', [QuizQuestionController::class, 'destroy']);
    });
});

