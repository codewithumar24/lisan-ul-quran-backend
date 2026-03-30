<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\PracticeExerciseRepositoryContract;
use Modules\Admin\Contracts\Services\PracticeExerciseContract;
use Modules\Admin\DataTransfer\Requests\PracticeExerciseDTO;
use Modules\Admin\Entities\PracticeExercise;

readonly class PracticeExerciseService implements PracticeExerciseContract
{
    public function __construct(
        private PracticeExerciseRepositoryContract $practiceExerciseRepository
    ) {}

    public function create(PracticeExerciseDTO $dto): PracticeExercise
    {
        // Check if exercise with same title exists in the lesson
        if ($this->practiceExerciseRepository->existsInLesson(
            $dto->getLessonId(),
            $dto->getTitleEnglish()
        )) {
            throw new \Exception("Practice exercise with this title already exists in the lesson.", 422);
        }

        // Get next display order if not provided
        $displayOrder = $dto->getDisplayOrder() ?:
            $this->practiceExerciseRepository->getNextDisplayOrder($dto->getLessonId());

        return $this->practiceExerciseRepository->create(
            $dto->getLessonId(),
            $dto->getTitleEnglish(),
            $dto->getTitleUrdu(),
            $dto->getExerciseType(),
            $dto->getInstructionsEnglish(),
            $dto->getInstructionsUrdu(),
            $dto->getContent(),
            $dto->getPoints(),
            $dto->getDifficultyLevel(),
            $dto->getCorrectResponse(),
            $dto->getOptions(),
            $dto->getAudioPrompt(),
            $dto->getCorrectAudio(),
            $displayOrder
        );
    }

    public function update(PracticeExercise $practiceExercise, PracticeExerciseDTO $dto): PracticeExercise
    {
        // Check if updating to a different title that already exists in the lesson
        if ($dto->getTitleEnglish() !== $practiceExercise->title_english) {
            if ($this->practiceExerciseRepository->existsInLesson(
                $dto->getLessonId() ?: $practiceExercise->lesson_id,
                $dto->getTitleEnglish(),
                $practiceExercise->id
            )) {
                throw new \Exception("Practice exercise with this title already exists in the lesson.", 422);
            }
        }

        return $this->practiceExerciseRepository->update(
            $practiceExercise,
            $dto->getLessonId(),
            $dto->getTitleEnglish(),
            $dto->getTitleUrdu(),
            $dto->getExerciseType(),
            $dto->getInstructionsEnglish(),
            $dto->getInstructionsUrdu(),
            $dto->getContent(),
            $dto->getPoints(),
            $dto->getDifficultyLevel(),
            $dto->getCorrectResponse(),
            $dto->getOptions(),
            $dto->getAudioPrompt(),
            $dto->getCorrectAudio(),
            $dto->getDisplayOrder()
        );
    }

    public function delete(PracticeExercise $practiceExercise): ?bool
    {
        // Check if exercise has user practice sessions
        if ($practiceExercise->userPracticeSessions()->exists()) {
            throw new \Exception("Cannot delete exercise because users have practiced it.", 422);
        }

        return $this->practiceExerciseRepository->delete($practiceExercise);
    }

    public function findById(int $id): ?PracticeExercise
    {
        return $this->practiceExerciseRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?PracticeExercise
    {
        return $this->practiceExerciseRepository->findByUuid($uuid);
    }

    public function getAll(
        ?int $perPage = null,
        ?int $lessonId = null,
        ?string $exerciseType = null,
        ?int $difficultyLevel = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        return $this->practiceExerciseRepository->getAll(
            $perPage,
            $lessonId,
            $exerciseType,
            $difficultyLevel,
            $search
        );
    }

    public function getByLesson(int $lessonId): Collection
    {
        return $this->practiceExerciseRepository->getByLesson($lessonId);
    }

    public function updateDisplayOrder(int $lessonId, array $orderData): bool
    {
        return $this->practiceExerciseRepository->updateDisplayOrder($lessonId, $orderData);
    }

    public function getNextDisplayOrder(int $lessonId): int
    {
        return $this->practiceExerciseRepository->getNextDisplayOrder($lessonId);
    }

    public function getExerciseTypes(): Collection
    {
        return collect([
            ['value' => 'repetition', 'label' => 'Repetition Exercise', 'icon' => 'repeat'],
            ['value' => 'pronunciation', 'label' => 'Pronunciation Exercise', 'icon' => 'mic'],
            ['value' => 'identification', 'label' => 'Letter Identification', 'icon' => 'search'],
            ['value' => 'listening', 'label' => 'Listening Exercise', 'icon' => 'headphones'],
            ['value' => 'recording', 'label' => 'Voice Recording', 'icon' => 'recording'],
        ]);
    }
}
