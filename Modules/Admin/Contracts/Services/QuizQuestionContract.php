<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\QuizQuestionDTO;
use Modules\Admin\Entities\QuizQuestion;

interface QuizQuestionContract
{
    /**
     * Create a new quiz question
     *
     * @param QuizQuestionDTO $dto
     * @return QuizQuestion
     */
    public function create(QuizQuestionDTO $dto): QuizQuestion;

    /**
     * Update an existing quiz question
     *
     * @param QuizQuestion $quizQuestion
     * @param QuizQuestionDTO $dto
     * @return QuizQuestion
     */
    public function update(QuizQuestion $quizQuestion, QuizQuestionDTO $dto): QuizQuestion;

    /**
     * Delete a quiz question
     *
     * @param QuizQuestion $quizQuestion
     * @return bool|null
     */
    public function delete(QuizQuestion $quizQuestion): ?bool;

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
     * Get all question types
     *
     * @return Collection
     */
    public function getQuestionTypes(): Collection;
}
