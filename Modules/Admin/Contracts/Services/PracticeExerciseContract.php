<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\PracticeExerciseDTO;
use Modules\Admin\Entities\PracticeExercise;

interface PracticeExerciseContract
{
    /**
     * Create a new practice exercise
     *
     * @param PracticeExerciseDTO $dto
     * @return PracticeExercise
     */
    public function create(PracticeExerciseDTO $dto): PracticeExercise;

    /**
     * Update an existing practice exercise
     *
     * @param PracticeExercise $practiceExercise
     * @param PracticeExerciseDTO $dto
     * @return PracticeExercise
     */
    public function update(PracticeExercise $practiceExercise, PracticeExerciseDTO $dto): PracticeExercise;

    /**
     * Delete a practice exercise
     *
     * @param PracticeExercise $practiceExercise
     * @return bool|null
     */
    public function delete(PracticeExercise $practiceExercise): ?bool;

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
     * Get all exercise types
     *
     * @return Collection
     */
    public function getExerciseTypes(): Collection;
}
