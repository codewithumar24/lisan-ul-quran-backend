<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\QuizQuestionContract;
use Modules\Admin\Http\Requests\QuizQuestionRequest;
use Modules\Admin\Transformers\QuizQuestionTransformer;

class QuizQuestionController extends Controller
{
    public function __construct(
        private readonly QuizQuestionContract $quizQuestionService
    ) {}

    public function getQuestionTypes(): JsonResponse
    {
        $types = $this->quizQuestionService->getQuestionTypes();
        return apiResponse()->success($types);
    }

    public function getByQuiz(int $quizId): JsonResponse
    {
        $questions = $this->quizQuestionService->getByQuiz($quizId);
        return apiResponse()->success(QuizQuestionTransformer::collection($questions));
    }

    public function getNextDisplayOrder(int $quizId): JsonResponse
    {
        $nextOrder = $this->quizQuestionService->getNextDisplayOrder($quizId);
        return apiResponse()->success(['next_display_order' => $nextOrder]);
    }

    public function store(QuizQuestionRequest $request): JsonResponse
    {
        try {
            $question = $this->quizQuestionService->create($request->getDTO());
            return apiResponse()->success(
                new QuizQuestionTransformer($question->load('quiz')),
                'Quiz question created successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function show(string $uuid): JsonResponse
    {
        $question = $this->quizQuestionService->findByUuid($uuid);

        if (!$question) {
            return apiResponse()->error('Quiz question not found.', 404);
        }

        return apiResponse()->success(new QuizQuestionTransformer($question->load('quiz')));
    }

    public function update(string $uuid, QuizQuestionRequest $request): JsonResponse
    {
        $question = $this->quizQuestionService->findByUuid($uuid);

        if (!$question) {
            return apiResponse()->error('Quiz question not found.', 404);
        }

        try {
            $updatedQuestion = $this->quizQuestionService->update($question, $request->getDTO());
            return apiResponse()->success(
                new QuizQuestionTransformer($updatedQuestion->load('quiz')),
                'Quiz question updated successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        $question = $this->quizQuestionService->findByUuid($uuid);

        if (!$question) {
            return apiResponse()->error('Quiz question not found.', 404);
        }

        try {
            $this->quizQuestionService->delete($question);
            return apiResponse()->success(null, 'Quiz question deleted successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function updateDisplayOrder(int $quizId): JsonResponse
    {
        $request = request();
        $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:quiz_questions,id'],
            'order.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->quizQuestionService->updateDisplayOrder($quizId, $request->input('order'));
            return apiResponse()->success(null, 'Display order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
