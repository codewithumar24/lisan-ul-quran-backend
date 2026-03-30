<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\QuizDTO;
use Modules\Admin\Entities\Quiz;

interface QuizContract
{
    /**
     * Create a new quiz
     *
     * @param QuizDTO $dto
     * @return Quiz
     */
    public function create(QuizDTO $dto): Quiz;

    /**
     * Update an existing quiz
     *
     * @param Quiz $quiz
     * @param QuizDTO $dto
     * @return Quiz
     */
    public function update(Quiz $quiz, QuizDTO $dto): Quiz;

    /**
     * Delete a quiz
     *
     * @param Quiz $quiz
     * @return bool|null
     */
    public function delete(Quiz $quiz): ?bool;

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
     * Publish a quiz
     *
     * @param Quiz $quiz
     * @return Quiz
     */
    public function publish(Quiz $quiz): Quiz;

    /**
     * Unpublish a quiz
     *
     * @param Quiz $quiz
     * @return Quiz
     */
    public function unpublish(Quiz $quiz): Quiz;

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
     * Get all quiz types
     *
     * @return Collection
     */
    public function getQuizTypes(): Collection;
}
