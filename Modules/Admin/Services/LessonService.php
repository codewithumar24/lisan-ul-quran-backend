<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\LessonRepositoryContract;
use Modules\Admin\Contracts\Services\LessonContract;
use Modules\Admin\DataTransfer\Requests\LessonDTO;
use Modules\Admin\Entities\Lesson;

readonly class LessonService implements LessonContract
{
    public function __construct(
        private LessonRepositoryContract $lessonRepository
    ) {}

    public function create(LessonDTO $dto): Lesson
    {
        // Check if lesson number already exists in chapter
        if ($this->lessonRepository->existsInChapter(
            $dto->getChapterNumber(),
            $dto->getLessonNumber()
        )) {
            throw new \Exception(
                "Lesson {$dto->getChapterNumber()}.{$dto->getLessonNumber()} already exists.",
                422
            );
        }

        // If no lesson number provided, get next available
        if (!$dto->getLessonNumber()) {
            $dto = LessonDTO::create(
                $dto->getTitleEnglish(),
                $dto->getTitleUrdu(),
                $dto->getTitleArabic(),
                $dto->getDescriptionEnglish(),
                $dto->getDescriptionUrdu(),
                $dto->getLessonType(),
                $dto->getChapterNumber(),
                $this->lessonRepository->getNextLessonNumber($dto->getChapterNumber()),
                $dto->getContent(),
                $dto->getLearningObjectives(),
                $dto->getEstimatedMinutes(),
                $dto->getPrerequisiteLessons(),
                $dto->getDifficultyLevel(),
                $dto->getThumbnailImage(),
                $dto->getVideoUrl(),
                $dto->getAttachments(),
                $dto->getIsPublished(),
                $dto->getPublishedAt(),
                $dto->getArabicLetterIds(),
                $dto->getTajweedRuleIds()
            );
        }

        return $this->lessonRepository->create(
            $dto->getTitleEnglish(),
            $dto->getTitleUrdu(),
            $dto->getTitleArabic(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getLessonType(),
            $dto->getChapterNumber(),
            $dto->getLessonNumber(),
            $dto->getContent(),
            $dto->getLearningObjectives(),
            $dto->getEstimatedMinutes(),
            $dto->getPrerequisiteLessons(),
            $dto->getDifficultyLevel(),
            $dto->getThumbnailImage(),
            $dto->getVideoUrl(),
            $dto->getAttachments(),
            $dto->getIsPublished(),
            $dto->getPublishedAt(),
            $dto->getArabicLetterIds(),
            $dto->getTajweedRuleIds()
        );
    }

    public function update(Lesson $lesson, LessonDTO $dto): Lesson
    {
        // Check if updating to a different chapter/lesson number that already exists
        if (($dto->getChapterNumber() !== $lesson->chapter_number ||
            $dto->getLessonNumber() !== $lesson->lesson_number)) {
            if ($this->lessonRepository->existsInChapter(
                $dto->getChapterNumber(),
                $dto->getLessonNumber(),
                $lesson->id
            )) {
                throw new \Exception(
                    "Lesson {$dto->getChapterNumber()}.{$dto->getLessonNumber()} already exists.",
                    422
                );
            }
        }

        return $this->lessonRepository->update(
            $lesson,
            $dto->getTitleEnglish(),
            $dto->getTitleUrdu(),
            $dto->getTitleArabic(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getLessonType(),
            $dto->getChapterNumber(),
            $dto->getLessonNumber(),
            $dto->getContent(),
            $dto->getLearningObjectives(),
            $dto->getEstimatedMinutes(),
            $dto->getPrerequisiteLessons(),
            $dto->getDifficultyLevel(),
            $dto->getThumbnailImage(),
            $dto->getVideoUrl(),
            $dto->getAttachments(),
            $dto->getIsPublished(),
            $dto->getPublishedAt(),
            $dto->getArabicLetterIds(),
            $dto->getTajweedRuleIds()
        );
    }

    public function delete(Lesson $lesson): ?bool
    {
        // Check if lesson has dependent data
        if ($lesson->practiceExercises()->exists() ||
            $lesson->quizzes()->exists() ||
            $lesson->userProgress()->exists()) {
            throw new \Exception("Cannot delete lesson because it has associated data.", 422);
        }

        return $this->lessonRepository->delete($lesson);
    }

    public function findById(int $id): ?Lesson
    {
        return $this->lessonRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?Lesson
    {
        return $this->lessonRepository->findByUuid($uuid);
    }

    public function findByChapterAndLesson(int $chapterNumber, int $lessonNumber): ?Lesson
    {
        return $this->lessonRepository->findByChapterAndLesson($chapterNumber, $lessonNumber);
    }

    public function getAll(
        ?int $perPage = null,
        ?string $lessonType = null,
        ?int $chapterNumber = null,
        ?int $difficultyLevel = null,
        ?bool $isPublished = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        return $this->lessonRepository->getAll(
            $perPage,
            $lessonType,
            $chapterNumber,
            $difficultyLevel,
            $isPublished,
            $search,
            ['arabicLetters', 'tajweedRules', 'prerequisites']
        );
    }

    public function getByChapter(int $chapterNumber): Collection
    {
        return $this->lessonRepository->getByChapter($chapterNumber);
    }

    public function getPublished(): Collection
    {
        return $this->lessonRepository->getPublished();
    }

    public function publish(Lesson $lesson): Lesson
    {
        return $this->lessonRepository->update(
            $lesson,
            isPublished: true,
            publishedAt: now()
        );
    }

    public function unpublish(Lesson $lesson): Lesson
    {
        return $this->lessonRepository->update(
            $lesson,
            isPublished: false,
            publishedAt: null
        );
    }

    public function getNextLessonNumber(int $chapterNumber): int
    {
        return $this->lessonRepository->getNextLessonNumber($chapterNumber);
    }

    public function updateOrder(array $orderData): bool
    {
        return $this->lessonRepository->updateOrder($orderData);
    }

    public function getLessonTypes(): Collection
    {
        return collect([
            ['value' => 'alphabet', 'label' => 'Alphabet Lesson'],
            ['value' => 'makhraj', 'label' => 'Makhraj Lesson'],
            ['value' => 'tajweed_rule', 'label' => 'Tajweed Rule Lesson'],
            ['value' => 'practice', 'label' => 'Practice Session'],
            ['value' => 'quiz', 'label' => 'Quiz'],
        ]);
    }
}
