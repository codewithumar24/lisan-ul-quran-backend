<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\QuizQuestion;

interface QuizQuestionRepositoryContract
{
    /**
     * Create a new quiz question
     *
     * @param int $quizId
     * @param string $questionEnglish
     * @param string $questionUrdu
     * @param string $questionType
     * @param array $options
     * @param array $correctAnswers
     * @param int $displayOrder
     * @param string|null $explanationEnglish
     * @param string|null $explanationUrdu
     * @param string|null $audioFile
     * @param string|null $imageFile
     * @param int $points
     * @param int $difficultyLevel
     * @return QuizQuestion
     */
    public function create(
        int $quizId,
        string $questionEnglish,
        string $questionUrdu,
        string $questionType,
        array $options,
        array $correctAnswers,
        int $displayOrder,
        ?string $explanationEnglish = null,
        ?string $explanationUrdu = null,
        ?string $audioFile = null,
        ?string $imageFile = null,
        int $points = 1,
        int $difficultyLevel = 1
    ): QuizQuestion;

    /**
     * Update an existing quiz question
     *
     * @param QuizQuestion $quizQuestion
     * @param string|null $questionEnglish
     * @param string|null $questionUrdu
     * @param string|null $questionType
     * @param array|null $options
     * @param array|null $correctAnswers
     * @param int|null $displayOrder
     * @param string|null $explanationEnglish
     * @param string|null $explanationUrdu
     * @param string|null $audioFile
     * @param string|null $imageFile
     * @param int|null $points
     * @param int|null $difficultyLevel
     * @return QuizQuestion
     */
    public function update(
        QuizQuestion $quizQuestion,
        ?string $questionEnglish = null,
        ?string $questionUrdu = null,
        ?string $questionType = null,
        ?array $options = null,
        ?array $correctAnswers = null,
        ?int $displayOrder = null,
        ?string $explanationEnglish = null,
        ?string $explanationUrdu = null,
        ?string $audioFile = null,
        ?string $imageFile = null,
        ?int $points = null,
        ?int $difficultyLevel = null
    ): QuizQuestion;

    /**
     * Delete a quiz question
     *
     * @param QuizQuestion $quizQuestion
     * @return bool
     */
    public function delete(QuizQuestion $quizQuestion): bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return QuizQuestion|null
     */
    public function findById(int $id): ?QuizQuestion;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return QuizQuestion|null
     */
    public function findByUuid(string $uuid): ?QuizQuestion;

    /**
     * Get questions by quiz
     *
     * @param int $quizId
     * @return Collection
     */
    public function getByQuiz(int $quizId): Collection;

    /**
     * Update display order for questions in a quiz
     *
     * @param int $quizId
     * @param array $orderData
     * @return bool
     */
    public function updateDisplayOrder(int $quizId, array $orderData): bool;

    /**
     * Get next display order for a quiz
     *
     * @param int $quizId
     * @return int
     */
    public function getNextDisplayOrder(int $quizId): int;

    /**
     * Check if question exists in quiz
     *
     * @param int $quizId
     * @param string $questionEnglish
     * @param int|null $excludeId
     * @return bool
     */
    public function existsInQuiz(int $quizId, string $questionEnglish, ?int $excludeId = null): bool;
}
