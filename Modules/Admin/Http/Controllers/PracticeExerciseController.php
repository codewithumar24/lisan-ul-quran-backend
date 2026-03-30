<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\PracticeExerciseContract;
use Modules\Admin\Http\Requests\PracticeExerciseRequest;
use Modules\Admin\Transformers\PracticeExerciseTransformer;

class PracticeExerciseController extends Controller
{
    public function __construct(
        private readonly PracticeExerciseContract $practiceExerciseService
    ) {}

    public function index(): JsonResponse
    {
        $exercises = $this->practiceExerciseService->getAll(
            request()->get('per_page'),
            request()->get('lesson_id') ? (int) request()->get('lesson_id') : null,
            request()->get('exercise_type'),
            request()->get('difficulty_level') ? (int) request()->get('difficulty_level') : null,
            request()->get('search')
        );

        return apiResponse()->pagination($exercises)->success(PracticeExerciseTransformer::collection($exercises));
    }

    public function getExerciseTypes(): JsonResponse
    {
        $types = $this->practiceExerciseService->getExerciseTypes();
        return apiResponse()->success($types);
    }

    public function getByLesson(int $lessonId): JsonResponse
    {
        $exercises = $this->practiceExerciseService->getByLesson($lessonId);
        return apiResponse()->success(PracticeExerciseTransformer::collection($exercises));
    }

    public function getNextDisplayOrder(int $lessonId): JsonResponse
    {
        $nextOrder = $this->practiceExerciseService->getNextDisplayOrder($lessonId);
        return apiResponse()->success(['next_display_order' => $nextOrder]);
    }

    public function store(PracticeExerciseRequest $request): JsonResponse
    {
        try {
            $exercise = $this->practiceExerciseService->create($request->getDTO());
            return apiResponse()->success(
                new PracticeExerciseTransformer($exercise->load('lesson')),
                'Practice exercise created successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function show(string $uuid): JsonResponse
    {
        $exercise = $this->practiceExerciseService->findByUuid($uuid);

        if (!$exercise) {
            return apiResponse()->error('Practice exercise not found.', 404);
        }

        return apiResponse()->success(new PracticeExerciseTransformer($exercise->load('lesson')));
    }

    public function update(string $uuid, PracticeExerciseRequest $request): JsonResponse
    {
        $exercise = $this->practiceExerciseService->findByUuid($uuid);

        if (!$exercise) {
            return apiResponse()->error('Practice exercise not found.', 404);
        }

        try {
            $updatedExercise = $this->practiceExerciseService->update($exercise, $request->getDTO());
            return apiResponse()->success(
                new PracticeExerciseTransformer($updatedExercise->load('lesson')),
                'Practice exercise updated successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        $exercise = $this->practiceExerciseService->findByUuid($uuid);

        if (!$exercise) {
            return apiResponse()->error('Practice exercise not found.', 404);
        }

        try {
            $this->practiceExerciseService->delete($exercise);
            return apiResponse()->success(null, 'Practice exercise deleted successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function updateDisplayOrder(int $lessonId): JsonResponse
    {
        $request = request();
        $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:practice_exercises,id'],
            'order.*.display_order' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->practiceExerciseService->updateDisplayOrder($lessonId, $request->input('order'));
            return apiResponse()->success(null, 'Display order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
