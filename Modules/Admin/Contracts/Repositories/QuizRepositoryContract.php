<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\Quiz;

interface QuizRepositoryContract
{
    /**
     * Create a new quiz
     *
     * @param string $titleEnglish
     * @param string $titleUrdu
     * @param string $descriptionEnglish
     * @param string $descriptionUrdu
     * @param string $quizType
     * @param int|null $lessonId
     * @param int|null $chapterNumber
     * @param int|null $timeLimitMinutes
     * @param int $passingScorePercentage
     * @param int $maxAttempts
     * @param bool $showAnswersAfter
     * @param bool $isPublished
     * @param int $displayOrder
     * @return Quiz
     */
    public function create(
        string $titleEnglish,
        string $titleUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        string $quizType,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?int $timeLimitMinutes = null,
        int $passingScorePercentage = 70,
        int $maxAttempts = 3,
        bool $showAnswersAfter = true,
        bool $isPublished = false,
        int $displayOrder = 0
    ): Quiz;

    /**
     * Update an existing quiz
     *
     * @param Quiz $quiz
     * @param string|null $titleEnglish
     * @param string|null $titleUrdu
     * @param string|null $descriptionEnglish
     * @param string|null $descriptionUrdu
     * @param string|null $quizType
     * @param int|null $lessonId
     * @param int|null $chapterNumber
     * @param int|null $timeLimitMinutes
     * @param int|null $passingScorePercentage
     * @param int|null $maxAttempts
     * @param bool|null $showAnswersAfter
     * @param bool|null $isPublished
     * @param int|null $displayOrder
     * @return Quiz
     */
    public function update(
        Quiz $quiz,
        ?string $titleEnglish = null,
        ?string $titleUrdu = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?string $quizType = null,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?int $timeLimitMinutes = null,
        ?int $passingScorePercentage = null,
        ?int $maxAttempts = null,
        ?bool $showAnswersAfter = null,
        ?bool $isPublished = null,
        ?int $displayOrder = null
    ): Quiz;

    /**
     * Delete a quiz
     *
     * @param Quiz $quiz
     * @return bool
     */
    public function delete(Quiz $quiz): bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return Quiz|null
     */
    public function findById(int $id): ?Quiz;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return Quiz|null
     */
    public function findByUuid(string $uuid): ?Quiz;

    /**
     * Get all quizzes with filters
     *
     * @param int|null $perPage
     * @param string|null $quizType
     * @param int|null $lessonId
     * @param int|null $chapterNumber
     * @param bool|null $isPublished
     * @param string|null $search
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?string $quizType = null,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?bool $isPublished = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection;

    /**
     * Get quizzes by lesson
     *
     * @param int $lessonId
     * @return Collection
     */
    public function getByLesson(int $lessonId): Collection;

    /**
     * Get quizzes by chapter
     *
     * @param int $chapterNumber
     * @return Collection
     */
    public function getByChapter(int $chapterNumber): Collection;

    /**
     * Update display order
     *
     * @param array $orderData
     * @return bool
     */
    public function updateDisplayOrder(array $orderData): bool;

    /**
     * Get next display order
     *
     * @return int
     */
    public function getNextDisplayOrder(): int;

    /**
     * Check if quiz title exists
     *
     * @param string $titleEnglish
     * @param int|null $excludeId
     * @return bool
     */
    public function existsByTitle(string $titleEnglish, ?int $excludeId = null): bool;
}
