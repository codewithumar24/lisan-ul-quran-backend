<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class PracticeExerciseDTO implements DTO
{
    public function __construct(
        private readonly int $lessonId,
        private readonly string $titleEnglish,
        private readonly string $titleUrdu,
        private readonly string $exerciseType,
        private readonly string $instructionsEnglish,
        private readonly string $instructionsUrdu,
        private readonly array $content,
        private readonly int $points,
        private readonly int $difficultyLevel,
        private readonly ?array $correctResponse,
        private readonly ?array $options,
        private readonly ?string $audioPrompt,
        private readonly ?string $correctAudio,
        private readonly ?int $displayOrder
    ) {}

    public static function create(
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
        ?int $displayOrder = null
    ): self {
        return new self(
            $lessonId,
            $titleEnglish,
            $titleUrdu,
            $exerciseType,
            $instructionsEnglish,
            $instructionsUrdu,
            $content,
            $points,
            $difficultyLevel,
            $correctResponse,
            $options,
            $audioPrompt,
            $correctAudio,
            $displayOrder
        );
    }

    public function getLessonId(): int { return $this->lessonId; }
    public function getTitleEnglish(): string { return $this->titleEnglish; }
    public function getTitleUrdu(): string { return $this->titleUrdu; }
    public function getExerciseType(): string { return $this->exerciseType; }
    public function getInstructionsEnglish(): string { return $this->instructionsEnglish; }
    public function getInstructionsUrdu(): string { return $this->instructionsUrdu; }
    public function getContent(): array { return $this->content; }
    public function getPoints(): int { return $this->points; }
    public function getDifficultyLevel(): int { return $this->difficultyLevel; }
    public function getCorrectResponse(): ?array { return $this->correctResponse; }
    public function getOptions(): ?array { return $this->options; }
    public function getAudioPrompt(): ?string { return $this->audioPrompt; }
    public function getCorrectAudio(): ?string { return $this->correctAudio; }
    public function getDisplayOrder(): ?int { return $this->displayOrder; }
}
