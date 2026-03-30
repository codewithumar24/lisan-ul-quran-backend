<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\QuizContract;
use Modules\Admin\Http\Requests\QuizRequest;
use Modules\Admin\Transformers\QuizTransformer;

class QuizController extends Controller
{
    public function __construct(
        private readonly QuizContract $quizService
    ) {}

    public function index(): JsonResponse
    {
        $quizzes = $this->quizService->getAll(
            request()->get('per_page'),
            request()->get('quiz_type'),
            request()->get('lesson_id') ? (int) request()->get('lesson_id') : null,
            request()->get('chapter_number') ? (int) request()->get('chapter_number') : null,
            request()->has('is_published') ? filter_var(request()->get('is_published'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->get('search')
        );

        return apiResponse()->pagination($quizzes)->success(QuizTransformer::collection($quizzes));
    }

    public function getQuizTypes(): JsonResponse
    {
        $types = $this->quizService->getQuizTypes();
        return apiResponse()->success($types);
    }

    public function getByLesson(int $lessonId): JsonResponse
    {
        $quizzes = $this->quizService->getByLesson($lessonId);
        return apiResponse()->success(QuizTransformer::collection($quizzes));
    }

    public function getByChapter(int $chapterNumber): JsonResponse
    {
        $quizzes = $this->quizService->getByChapter($chapterNumber);
        return apiResponse()->success(QuizTransformer::collection($quizzes));
    }

    public function getNextDisplayOrder(): JsonResponse
    {
        $nextOrder = $this->quizService->getNextDisplayOrder();
        return apiResponse()->success(['next_display_order' => $nextOrder]);
    }

    public function store(QuizRequest $request): JsonResponse
    {
        try {
            $quiz = $this->quizService->create($request->getDTO());
            return apiResponse()->success(
                new QuizTransformer($quiz->load('lesson')),
                'Quiz created successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function show(string $uuid): JsonResponse
    {
        $quiz = $this->quizService->findByUuid($uuid);

        if (!$quiz) {
            return apiResponse()->error('Quiz not found.', 404);
        }

        return apiResponse()->success(new QuizTransformer($quiz->load(['lesson', 'questions'])));
    }

    public function update(string $uuid, QuizRequest $request): JsonResponse
    {
        $quiz = $this->quizService->findByUuid($uuid);

        if (!$quiz) {
            return apiResponse()->error('Quiz not found.', 404);
        }

        try {
            $updatedQuiz = $this->quizService->update($quiz, $request->getDTO());
            return apiResponse()->success(
                new QuizTransformer($updatedQuiz->load('lesson')),
                'Quiz updated successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        $quiz = $this->quizService->findByUuid($uuid);

        if (!$quiz) {
            return apiResponse()->error('Quiz not found.', 404);
        }

        try {
            $this->quizService->delete($quiz);
            return apiResponse()->success(null, 'Quiz deleted successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function publish(string $uuid): JsonResponse
    {
        $quiz = $this->quizService->findByUuid($uuid);

        if (!$quiz) {
            return apiResponse()->error('Quiz not found.', 404);
        }

        try {
            $publishedQuiz = $this->quizService->publish($quiz);
            return apiResponse()->success(new QuizTransformer($publishedQuiz), 'Quiz published successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function unpublish(string $uuid): JsonResponse
    {
        $quiz = $this->quizService->findByUuid($uuid);

        if (!$quiz) {
            return apiResponse()->error('Quiz not found.', 404);
        }

        $unpublishedQuiz = $this->quizService->unpublish($quiz);
        return apiResponse()->success(new QuizTransformer($unpublishedQuiz), 'Quiz unpublished successfully.');
    }

    public function updateDisplayOrder(): JsonResponse
    {
        $request = request();
        $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:quizzes,id'],
            'order.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->quizService->updateDisplayOrder($request->input('order'));
            return apiResponse()->success(null, 'Display order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
