<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class QuizDTO implements DTO
{
    public function __construct(
        private readonly string $titleEnglish,
        private readonly string $titleUrdu,
        private readonly string $descriptionEnglish,
        private readonly string $descriptionUrdu,
        private readonly string $quizType,
        private readonly ?int $lessonId,
        private readonly ?int $chapterNumber,
        private readonly ?int $timeLimitMinutes,
        private readonly int $passingScorePercentage,
        private readonly int $maxAttempts,
        private readonly bool $showAnswersAfter,
        private readonly bool $isPublished,
        private readonly ?int $displayOrder
    ) {}

    public static function create(
        string $titleEnglish,
        string $titleUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        string $quizType,
        ?int $lessonId = null,
        ?int $chapterNumber = null,
        ?int $timeLimitMinutes = null,
        int $passingScorePercentage = 70,
        int $maxAttempts = 3,
        bool $showAnswersAfter = true,
        bool $isPublished = false,
        ?int $displayOrder = null
    ): self {
        return new self(
            $titleEnglish,
            $titleUrdu,
            $descriptionEnglish,
            $descriptionUrdu,
            $quizType,
            $lessonId,
            $chapterNumber,
            $timeLimitMinutes,
            $passingScorePercentage,
            $maxAttempts,
            $showAnswersAfter,
            $isPublished,
            $displayOrder
        );
    }

    public function getTitleEnglish(): string { return $this->titleEnglish; }
    public function getTitleUrdu(): string { return $this->titleUrdu; }
    public function getDescriptionEnglish(): string { return $this->descriptionEnglish; }
    public function getDescriptionUrdu(): string { return $this->descriptionUrdu; }
    public function getQuizType(): string { return $this->quizType; }
    public function getLessonId(): ?int { return $this->lessonId; }
    public function getChapterNumber(): ?int { return $this->chapterNumber; }
    public function getTimeLimitMinutes(): ?int { return $this->timeLimitMinutes; }
    public function getPassingScorePercentage(): int { return $this->passingScorePercentage; }
    public function getMaxAttempts(): int { return $this->maxAttempts; }
    public function getShowAnswersAfter(): bool { return $this->showAnswersAfter; }
    public function getIsPublished(): bool { return $this->isPublished; }
    public function getDisplayOrder(): ?int { return $this->displayOrder; }
}
