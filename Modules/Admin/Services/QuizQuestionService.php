<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\QuizQuestionRepositoryContract;
use Modules\Admin\Contracts\Services\QuizQuestionContract;
use Modules\Admin\DataTransfer\Requests\QuizQuestionDTO;
use Modules\Admin\Entities\QuizQuestion;

readonly class QuizQuestionService implements QuizQuestionContract
{
    public function __construct(
        private QuizQuestionRepositoryContract $quizQuestionRepository
    ) {}

    public function create(QuizQuestionDTO $dto): QuizQuestion
    {
        // Check if question with same text exists in quiz
        if ($this->quizQuestionRepository->existsInQuiz(
            $dto->getQuizId(),
            $dto->getQuestionEnglish()
        )) {
            throw new \Exception("Question with this text already exists in the quiz.", 422);
        }

        // Get next display order if not provided
        $displayOrder = $dto->getDisplayOrder() ?:
            $this->quizQuestionRepository->getNextDisplayOrder($dto->getQuizId());

        // Validate based on question type
        $this->validateQuestionData($dto);

        return $this->quizQuestionRepository->create(
            $dto->getQuizId(),
            $dto->getQuestionEnglish(),
            $dto->getQuestionUrdu(),
            $dto->getQuestionType(),
            $dto->getOptions(),
            $dto->getCorrectAnswers(),
            $displayOrder,
            $dto->getExplanationEnglish(),
            $dto->getExplanationUrdu(),
            $dto->getAudioFile(),
            $dto->getImageFile(),
            $dto->getPoints(),
            $dto->getDifficultyLevel()
        );
    }

    public function update(QuizQuestion $quizQuestion, QuizQuestionDTO $dto): QuizQuestion
    {
        // Check if updating to a different question text that already exists
        if ($dto->getQuestionEnglish() && $dto->getQuestionEnglish() !== $quizQuestion->question_english) {
            if ($this->quizQuestionRepository->existsInQuiz(
                $dto->getQuizId() ?: $quizQuestion->quiz_id,
                $dto->getQuestionEnglish(),
                $quizQuestion->id
            )) {
                throw new \Exception("Question with this text already exists in the quiz.", 422);
            }
        }

        // Validate based on question type
        if ($dto->getQuestionType() || $dto->getOptions() || $dto->getCorrectAnswers()) {
            $this->validateQuestionData($dto);
        }

        return $this->quizQuestionRepository->update(
            $quizQuestion,
            $dto->getQuestionEnglish(),
            $dto->getQuestionUrdu(),
            $dto->getQuestionType(),
            $dto->getOptions(),
            $dto->getCorrectAnswers(),
            $dto->getDisplayOrder(),
            $dto->getExplanationEnglish(),
            $dto->getExplanationUrdu(),
            $dto->getAudioFile(),
            $dto->getImageFile(),
            $dto->getPoints(),
            $dto->getDifficultyLevel()
        );
    }

    public function delete(QuizQuestion $quizQuestion): ?bool
    {
        return $this->quizQuestionRepository->delete($quizQuestion);
    }

    public function findById(int $id): ?QuizQuestion
    {
        return $this->quizQuestionRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?QuizQuestion
    {
        return $this->quizQuestionRepository->findByUuid($uuid);
    }

    public function getByQuiz(int $quizId): Collection
    {
        return $this->quizQuestionRepository->getByQuiz($quizId);
    }

    public function updateDisplayOrder(int $quizId, array $orderData): bool
    {
        return $this->quizQuestionRepository->updateDisplayOrder($quizId, $orderData);
    }

    public function getNextDisplayOrder(int $quizId): int
    {
        return $this->quizQuestionRepository->getNextDisplayOrder($quizId);
    }

    public function getQuestionTypes(): Collection
    {
        return collect([
            ['value' => 'multiple_choice', 'label' => 'Multiple Choice', 'icon' => 'list'],
            ['value' => 'true_false', 'label' => 'True/False', 'icon' => 'check'],
            ['value' => 'matching', 'label' => 'Matching', 'icon' => 'link'],
            ['value' => 'audio_identification', 'label' => 'Audio Identification', 'icon' => 'headphones'],
            ['value' => 'pronunciation_check', 'label' => 'Pronunciation Check', 'icon' => 'mic'],
        ]);
    }

    private function validateQuestionData(QuizQuestionDTO $dto): void
    {
        switch ($dto->getQuestionType()) {
            case 'multiple_choice':
                if (empty($dto->getOptions()) || count($dto->getOptions()) < 2) {
                    throw new \Exception("Multiple choice questions must have at least 2 options.", 422);
                }
                if (empty($dto->getCorrectAnswers()) || count($dto->getCorrectAnswers()) !== 1) {
                    throw new \Exception("Multiple choice questions must have exactly one correct answer.", 422);
                }
                break;

            case 'true_false':
                if (empty($dto->getOptions()) || count($dto->getOptions()) !== 2) {
                    throw new \Exception("True/False questions must have exactly 2 options.", 422);
                }
                break;

            case 'matching':
                if (empty($dto->getOptions()) || count($dto->getOptions()) < 2) {
                    throw new \Exception("Matching questions must have at least 2 pairs.", 422);
                }
                break;

            case 'audio_identification':
                if (!$dto->getAudioFile()) {
                    throw new \Exception("Audio identification questions must have an audio file.", 422);
                }
                break;
        }
    }
}
