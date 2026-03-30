<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class QuizQuestionDTO implements DTO
{
    public function __construct(
        private readonly int $quizId,
        private readonly string $questionEnglish,
        private readonly string $questionUrdu,
        private readonly string $questionType,
        private readonly array $options,
        private readonly array $correctAnswers,
        private readonly ?int $displayOrder,
        private readonly ?string $explanationEnglish,
        private readonly ?string $explanationUrdu,
        private readonly ?string $audioFile,
        private readonly ?string $imageFile,
        private readonly int $points,
        private readonly int $difficultyLevel
    ) {}

    public static function create(
        int $quizId,
        string $questionEnglish,
        string $questionUrdu,
        string $questionType,
        array $options,
        array $correctAnswers,
        ?int $displayOrder = null,
        ?string $explanationEnglish = null,
        ?string $explanationUrdu = null,
        ?string $audioFile = null,
        ?string $imageFile = null,
        int $points = 1,
        int $difficultyLevel = 1
    ): self {
        return new self(
            $quizId,
            $questionEnglish,
            $questionUrdu,
            $questionType,
            $options,
            $correctAnswers,
            $displayOrder,
            $explanationEnglish,
            $explanationUrdu,
            $audioFile,
            $imageFile,
            $points,
            $difficultyLevel
        );
    }

    public function getQuizId(): int { return $this->quizId; }
    public function getQuestionEnglish(): string { return $this->questionEnglish; }
    public function getQuestionUrdu(): string { return $this->questionUrdu; }
    public function getQuestionType(): string { return $this->questionType; }
    public function getOptions(): array { return $this->options; }
    public function getCorrectAnswers(): array { return $this->correctAnswers; }
    public function getDisplayOrder(): ?int { return $this->displayOrder; }
    public function getExplanationEnglish(): ?string { return $this->explanationEnglish; }
    public function getExplanationUrdu(): ?string { return $this->explanationUrdu; }
    public function getAudioFile(): ?string { return $this->audioFile; }
    public function getImageFile(): ?string { return $this->imageFile; }
    public function getPoints(): int { return $this->points; }
    public function getDifficultyLevel(): int { return $this->difficultyLevel; }
}
