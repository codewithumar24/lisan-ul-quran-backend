<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Admin\Contracts\Services\LessonContract;
use Modules\Admin\Http\Requests\LessonRequest;
use Modules\Admin\Transformers\LessonTransformer;

class LessonController extends Controller
{
    public function __construct(
        private readonly LessonContract $lessonService
    ) {}

    /**
     * Get all lessons with filters
     */
    public function index(): JsonResponse
    {
        $lessons = $this->lessonService->getAll(
            request()->get('per_page'),
            request()->get('lesson_type'),
            request()->get('chapter_number') ? (int) request()->get('chapter_number') : null,
            request()->get('difficulty_level') ? (int) request()->get('difficulty_level') : null,
            request()->has('is_published') ? filter_var(request()->get('is_published'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->get('search')
        );

        return apiResponse()->pagination($lessons)->success(LessonTransformer::collection($lessons));
    }

    /**
     * Get all lesson types
     */
    public function getLessonTypes(): JsonResponse
    {
        $types = $this->lessonService->getLessonTypes();
        return apiResponse()->success($types);
    }

    /**
     * Get lessons by chapter
     */
    public function getByChapter(int $chapterNumber): JsonResponse
    {
        $lessons = $this->lessonService->getByChapter($chapterNumber);
        return apiResponse()->success(LessonTransformer::collection($lessons));
    }

    /**
     * Get published lessons
     */
    public function getPublished(): JsonResponse
    {
        $lessons = $this->lessonService->getPublished();
        return apiResponse()->success(LessonTransformer::collection($lessons));
    }

    /**
     * Get next lesson number in chapter
     */
    public function getNextLessonNumber(int $chapterNumber): JsonResponse
    {
        $nextNumber = $this->lessonService->getNextLessonNumber($chapterNumber);
        return apiResponse()->success(['next_lesson_number' => $nextNumber]);
    }

    /**
     * Create a new lesson
     */
    public function store(LessonRequest $request): JsonResponse
    {
        try {
            $lesson = $this->lessonService->create($request->getDTO());
            return apiResponse()->success(
                new LessonTransformer($lesson->load(['arabicLetters', 'tajweedRules'])),
                'Lesson created successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Get a specific lesson by UUID
     */
    public function show(string $uuid): JsonResponse
    {
        $lesson = $this->lessonService->findByUuid($uuid);

        if (!$lesson) {
            return apiResponse()->error('Lesson not found.', 404);
        }

        return apiResponse()->success(
            new LessonTransformer($lesson->load(['arabicLetters', 'tajweedRules', 'prerequisites']))
        );
    }

    /**
     * Update a lesson
     */
    public function update(string $uuid, LessonRequest $request): JsonResponse
    {
        $lesson = $this->lessonService->findByUuid($uuid);

        if (!$lesson) {
            return apiResponse()->error('Lesson not found.', 404);
        }

        try {
            $updatedLesson = $this->lessonService->update($lesson, $request->getDTO());
            return apiResponse()->success(
                new LessonTransformer($updatedLesson->load(['arabicLetters', 'tajweedRules'])),
                'Lesson updated successfully.'
            );
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Delete a lesson
     */
    public function destroy(string $uuid): JsonResponse
    {
        $lesson = $this->lessonService->findByUuid($uuid);

        if (!$lesson) {
            return apiResponse()->error('Lesson not found.', 404);
        }

        try {
            $this->lessonService->delete($lesson);
            return apiResponse()->success(null, 'Lesson deleted successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    /**
     * Publish a lesson
     */
    public function publish(string $uuid): JsonResponse
    {
        $lesson = $this->lessonService->findByUuid($uuid);

        if (!$lesson) {
            return apiResponse()->error('Lesson not found.', 404);
        }

        $publishedLesson = $this->lessonService->publish($lesson);
        return apiResponse()->success(new LessonTransformer($publishedLesson), 'Lesson published successfully.');
    }

    /**
     * Unpublish a lesson
     */
    public function unpublish(string $uuid): JsonResponse
    {
        $lesson = $this->lessonService->findByUuid($uuid);

        if (!$lesson) {
            return apiResponse()->error('Lesson not found.', 404);
        }

        $unpublishedLesson = $this->lessonService->unpublish($lesson);
        return apiResponse()->success(new LessonTransformer($unpublishedLesson), 'Lesson unpublished successfully.');
    }

    /**
     * Update lesson order
     */
    public function updateOrder(): JsonResponse
    {
        $request = request();
        $request->validate([
            'order' => ['required', 'array'],
            'order.*.id' => ['required', 'integer', 'exists:lessons,id'],
            'order.*.chapter_number' => ['required', 'integer', 'min:1'],
            'order.*.lesson_number' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $this->lessonService->updateOrder($request->input('order'));
            return apiResponse()->success(null, 'Lesson order updated successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }
}
