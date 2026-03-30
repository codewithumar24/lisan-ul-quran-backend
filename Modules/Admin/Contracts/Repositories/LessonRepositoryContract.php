<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\Lesson;

interface LessonRepositoryContract
{
    /**
     * Create a new lesson
     *
     * @param string $titleEnglish
     * @param string $titleUrdu
     * @param string|null $titleArabic
     * @param string $descriptionEnglish
     * @param string $descriptionUrdu
     * @param string $lessonType
     * @param int $chapterNumber
     * @param int $lessonNumber
     * @param array $content
     * @param array $learningObjectives
     * @param int $estimatedMinutes
     * @param array|null $prerequisiteLessons
     * @param int $difficultyLevel
     * @param string|null $thumbnailImage
     * @param string|null $videoUrl
     * @param array|null $attachments
     * @param bool $isPublished
     * @param string|null $publishedAt
     * @param array $arabicLetterIds
     * @param array $tajweedRuleIds
     * @return Lesson
     */
    public function create(
        string $titleEnglish,
        string $titleUrdu,
        ?string $titleArabic,
        string $descriptionEnglish,
        string $descriptionUrdu,
        string $lessonType,
        int $chapterNumber,
        int $lessonNumber,
        array $content,
        array $learningObjectives,
        int $estimatedMinutes,
        ?array $prerequisiteLessons = null,
        int $difficultyLevel = 1,
        ?string $thumbnailImage = null,
        ?string $videoUrl = null,
        ?array $attachments = null,
        bool $isPublished = false,
        ?string $publishedAt = null,
        array $arabicLetterIds = [],
        array $tajweedRuleIds = []
    ): Lesson;

    /**
     * Update an existing lesson
     *
     * @param Lesson $lesson
     * @param string|null $titleEnglish
     * @param string|null $titleUrdu
     * @param string|null $titleArabic
     * @param string|null $descriptionEnglish
     * @param string|null $descriptionUrdu
     * @param string|null $lessonType
     * @param int|null $chapterNumber
     * @param int|null $lessonNumber
     * @param array|null $content
     * @param array|null $learningObjectives
     * @param int|null $estimatedMinutes
     * @param array|null $prerequisiteLessons
     * @param int|null $difficultyLevel
     * @param string|null $thumbnailImage
     * @param string|null $videoUrl
     * @param array|null $attachments
     * @param bool|null $isPublished
     * @param string|null $publishedAt
     * @param array|null $arabicLetterIds
     * @param array|null $tajweedRuleIds
     * @return Lesson
     */
    public function update(
        Lesson $lesson,
        ?string $titleEnglish = null,
        ?string $titleUrdu = null,
        ?string $titleArabic = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?string $lessonType = null,
        ?int $chapterNumber = null,
        ?int $lessonNumber = null,
        ?array $content = null,
        ?array $learningObjectives = null,
        ?int $estimatedMinutes = null,
        ?array $prerequisiteLessons = null,
        ?int $difficultyLevel = null,
        ?string $thumbnailImage = null,
        ?string $videoUrl = null,
        ?array $attachments = null,
        ?bool $isPublished = null,
        ?string $publishedAt = null,
        ?array $arabicLetterIds = null,
        ?array $tajweedRuleIds = null
    ): Lesson;

    /**
     * Delete a lesson
     *
     * @param Lesson $lesson
     * @return bool
     */
    public function delete(Lesson $lesson): bool;

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
     * @param array $with
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?string $lessonType = null,
        ?int $chapterNumber = null,
        ?int $difficultyLevel = null,
        ?bool $isPublished = null,
        ?string $search = null,
        array $with = []
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
     * Sync Arabic letters for a lesson
     *
     * @param Lesson $lesson
     * @param array $arabicLetterIds
     * @return void
     */
    public function syncArabicLetters(Lesson $lesson, array $arabicLetterIds): void;

    /**
     * Sync Tajweed rules for a lesson
     *
     * @param Lesson $lesson
     * @param array $tajweedRuleIds
     * @return void
     */
    public function syncTajweedRules(Lesson $lesson, array $tajweedRuleIds): void;

    /**
     * Check if lesson number exists in chapter
     *
     * @param int $chapterNumber
     * @param int $lessonNumber
     * @param int|null $excludeId
     * @return bool
     */
    public function existsInChapter(int $chapterNumber, int $lessonNumber, ?int $excludeId = null): bool;

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
     * @param array $orderData [['id' => 1, 'chapter_number' => 1, 'lesson_number' => 1], ...]
     * @return bool
     */
    public function updateOrder(array $orderData): bool;
}
