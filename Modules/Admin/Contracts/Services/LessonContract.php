<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\LessonDTO;
use Modules\Admin\Entities\Lesson;

interface LessonContract
{
    /**
     * Create a new lesson
     *
     * @param LessonDTO $dto
     * @return Lesson
     */
    public function create(LessonDTO $dto): Lesson;

    /**
     * Update an existing lesson
     *
     * @param Lesson $lesson
     * @param LessonDTO $dto
     * @return Lesson
     */
    public function update(Lesson $lesson, LessonDTO $dto): Lesson;

    /**
     * Delete a lesson
     *
     * @param Lesson $lesson
     * @return bool|null
     */
    public function delete(Lesson $lesson): ?bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return Lesson|null
     */
    public function findById(int $id): ?Lesson;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return Lesson|null
     */
    public function findByUuid(string $uuid): ?Lesson;

    /**
     * Find by chapter and lesson number
     *
     * @param int $chapterNumber
     * @param int $lessonNumber
     * @return Lesson|null
     */
    public function findByChapterAndLesson(int $chapterNumber, int $lessonNumber): ?Lesson;

    /**
     * Get all lessons with filters
     *
     * @param int|null $perPage
     * @param string|null $lessonType
     * @param int|null $chapterNumber
     * @param int|null $difficultyLevel
     * @param bool|null $isPublished
     * @param string|null $search
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?string $lessonType = null,
        ?int $chapterNumber = null,
        ?int $difficultyLevel = null,
        ?bool $isPublished = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection;

    /**
     * Get lessons by chapter
     *
     * @param int $chapterNumber
     * @return Collection
     */
    public function getByChapter(int $chapterNumber): Collection;

    /**
     * Get published lessons
     *
     * @return Collection
     */
    public function getPublished(): Collection;

    /**
     * Publish a lesson
     *
     * @param Lesson $lesson
     * @return Lesson
     */
    public function publish(Lesson $lesson): Lesson;

    /**
     * Unpublish a lesson
     *
     * @param Lesson $lesson
     * @return Lesson
     */
    public function unpublish(Lesson $lesson): Lesson;

    /**
     * Get next lesson number in chapter
     *
     * @param int $chapterNumber
     * @return int
     */
    public function getNextLessonNumber(int $chapterNumber): int;

    /**
     * Update lesson order
     *
     * @param array $orderData
     * @return bool
     */
    public function updateOrder(array $orderData): bool;

    /**
     * Get all lesson types
     *
     * @return Collection
     */
    public function getLessonTypes(): Collection;
}
