<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\PracticeExercise;

interface PracticeExerciseRepositoryContract
{
    /**
     * Create a new practice exercise
     *
     * @param int $lessonId
     * @param string $titleEnglish
     * @param string $titleUrdu
     * @param string $exerciseType
     * @param string $instructionsEnglish
     * @param string $instructionsUrdu
     * @param array $content
     * @param int $points
     * @param int $difficultyLevel
     * @param array|null $correctResponse
     * @param array|null $options
     * @param string|null $audioPrompt
     * @param string|null $correctAudio
     * @param int $displayOrder
     * @return PracticeExercise
     */
    public function create(
        int $lessonId,
        string $titleEnglish,
        string $titleUrdu,
        string $exerciseType,
        string $instructionsEnglish,
        string $instructionsUrdu,
        array $content,
        int $points = 10,
        int $difficultyLevel = 1,
        ?array $correctResponse = null,
        ?array $options = null,
        ?string $audioPrompt = null,
        ?string $correctAudio = null,
        int $displayOrder = 0
    ): PracticeExercise;

    /**
     * Update an existing practice exercise
     *
     * @param PracticeExercise $practiceExercise
     * @param int|null $lessonId
     * @param string|null $titleEnglish
     * @param string|null $titleUrdu
     * @param string|null $exerciseType
     * @param string|null $instructionsEnglish
     * @param string|null $instructionsUrdu
     * @param array|null $content
     * @param int|null $points
     * @param int|null $difficultyLevel
     * @param array|null $correctResponse
     * @param array|null $options
     * @param string|null $audioPrompt
     * @param string|null $correctAudio
     * @param int|null $displayOrder
     * @return PracticeExercise
     */
    public function update(
        PracticeExercise $practiceExercise,
        ?int $lessonId = null,
        ?string $titleEnglish = null,
        ?string $titleUrdu = null,
        ?string $exerciseType = null,
        ?string $instructionsEnglish = null,
        ?string $instructionsUrdu = null,
        ?array $content = null,
        ?int $points = null,
        ?int $difficultyLevel = null,
        ?array $correctResponse = null,
        ?array $options = null,
        ?string $audioPrompt = null,
        ?string $correctAudio = null,
        ?int $displayOrder = null
    ): PracticeExercise;

    /**
     * Delete a practice exercise
     *
     * @param PracticeExercise $practiceExercise
     * @return bool
     */
    public function delete(PracticeExercise $practiceExercise): bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return PracticeExercise|null
     */
    public function findById(int $id): ?PracticeExercise;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return PracticeExercise|null
     */
    public function findByUuid(string $uuid): ?PracticeExercise;

    /**
     * Get all practice exercises with filters
     *
     * @param int|null $perPage
     * @param int|null $lessonId
     * @param string|null $exerciseType
     * @param int|null $difficultyLevel
     * @param string|null $search
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?int $lessonId = null,
        ?string $exerciseType = null,
        ?int $difficultyLevel = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection;

    /**
     * Get exercises by lesson
     *
     * @param int $lessonId
     * @return Collection
     */
    public function getByLesson(int $lessonId): Collection;

    /**
     * Update display order for exercises in a lesson
     *
     * @param int $lessonId
     * @param array $orderData
     * @return bool
     */
    public function updateDisplayOrder(int $lessonId, array $orderData): bool;

    /**
     * Get next display order for a lesson
     *
     * @param int $lessonId
     * @return int
     */
    public function getNextDisplayOrder(int $lessonId): int;

    /**
     * Check if exercise title exists in lesson
     *
     * @param int $lessonId
     * @param string $titleEnglish
     * @param int|null $excludeId
     * @return bool
     */
    public function existsInLesson(int $lessonId, string $titleEnglish, ?int $excludeId = null): bool;
}
