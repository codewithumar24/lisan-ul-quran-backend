<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\QuizRepositoryContract;
use Modules\Admin\Contracts\Services\QuizContract;
use Modules\Admin\DataTransfer\Requests\QuizDTO;
use Modules\Admin\Entities\Quiz;

readonly class QuizService implements QuizContract
{
    public function __construct(
        private QuizRepositoryContract $quizRepository
    ) {}

    public function create(QuizDTO $dto): Quiz
    {
        // Check if quiz with same title exists
        if ($this->quizRepository->existsByTitle($dto->getTitleEnglish())) {
            throw new \Exception("Quiz with this title already exists.", 422);
        }

        // Get next display order if not provided
        $displayOrder = $dto->getDisplayOrder() ?: $this->quizRepository->getNextDisplayOrder();

        // Validate based on quiz type
        if ($dto->getQuizType() === 'lesson_quiz' && !$dto->getLessonId()) {
            throw new \Exception("Lesson ID is required for lesson quiz.", 422);
        }

        if ($dto->getQuizType() === 'chapter_quiz' && !$dto->getChapterNumber()) {
            throw new \Exception("Chapter number is required for chapter quiz.", 422);
        }

        return $this->quizRepository->create(
            $dto->getTitleEnglish(),
            $dto->getTitleUrdu(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getQuizType(),
            $dto->getLessonId(),
            $dto->getChapterNumber(),
            $dto->getTimeLimitMinutes(),
            $dto->getPassingScorePercentage(),
            $dto->getMaxAttempts(),
            $dto->getShowAnswersAfter(),
            $dto->getIsPublished(),
            $displayOrder
        );
    }

    public function update(Quiz $quiz, QuizDTO $dto): Quiz
    {
        // Check if updating to a different title that already exists
        if ($dto->getTitleEnglish() && $dto->getTitleEnglish() !== $quiz->title_english) {
            if ($this->quizRepository->existsByTitle($dto->getTitleEnglish(), $quiz->id)) {
                throw new \Exception("Quiz with this title already exists.", 422);
            }
        }

        // Validate based on quiz type
        if ($dto->getQuizType() === 'lesson_quiz' && $dto->getLessonId() === null && !$quiz->lesson_id) {
            throw new \Exception("Lesson ID is required for lesson quiz.", 422);
        }

        if ($dto->getQuizType() === 'chapter_quiz' && $dto->getChapterNumber() === null && !$quiz->chapter_number) {
            throw new \Exception("Chapter number is required for chapter quiz.", 422);
        }

        return $this->quizRepository->update(
            $quiz,
            $dto->getTitleEnglish(),
            $dto->getTitleUrdu(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getQuizType(),
            $dto->getLessonId(),
            $dto->getChapterNumber(),
            $dto->getTimeLimitMinutes(),
            $dto->getPassingScorePercentage(),
            $dto->getMaxAttempts(),
            $dto->getShowAnswersAfter(),
            $dto->getIsPublished(),
            $dto->getDisplayOrder()
        );
    }

    public function delete(Quiz $quiz): ?bool
    {
        // Check if quiz has user attempts
        if ($quiz->userAttempts()->exists()) {
            throw new \Exception("Cannot delete quiz because users have attempted it.", 422);
        }

        return $this->quizRepository->delete($quiz);
    }

    public function findById(int $id): ?Quiz
    {
        return $this->quizRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?Quiz
    {
        return $this->quizRepository->findByUuid($uuid);
    }

    public function getAll(
        ?int $perPage = null,
        ?string $quizType = null,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?bool $isPublished = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        return $this->quizRepository->getAll(
            $perPage,
            $quizType,
            $lessonId,
            $chapterNumber,
            $isPublished,
            $search
        );
    }

    public function getByLesson(int $lessonId): Collection
    {
        return $this->quizRepository->getByLesson($lessonId);
    }

    public function getByChapter(int $chapterNumber): Collection
    {
        return $this->quizRepository->getByChapter($chapterNumber);
    }

    public function publish(Quiz $quiz): Quiz
    {
        if ($quiz->questions()->count() === 0) {
            throw new \Exception("Cannot publish quiz with no questions.", 422);
        }

        return $this->quizRepository->update(
            $quiz,
            isPublished: true
        );
    }

    public function unpublish(Quiz $quiz): Quiz
    {
        return $this->quizRepository->update(
            $quiz,
            isPublished: false
        );
    }

    public function updateDisplayOrder(array $orderData): bool
    {
        return $this->quizRepository->updateDisplayOrder($orderData);
    }

    public function getNextDisplayOrder(): int
    {
        return $this->quizRepository->getNextDisplayOrder();
    }

    public function getQuizTypes(): Collection
    {
        return collect([
            ['value' => 'lesson_quiz', 'label' => 'Lesson Quiz', 'description' => 'Quiz for a specific lesson'],
            ['value' => 'chapter_quiz', 'label' => 'Chapter Quiz', 'description' => 'Quiz for an entire chapter'],
            ['value' => 'final_assessment', 'label' => 'Final Assessment', 'description' => 'Comprehensive final exam'],
        ]);
    }
}
