<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class TajweedRuleDTO implements DTO
{
    public function __construct(
        private readonly string $ruleCategory,
        private readonly string $ruleNameEnglish,
        private readonly string $ruleNameArabic,
        private readonly string $ruleNameUrdu,
        private readonly string $descriptionEnglish,
        private readonly string $descriptionUrdu,
        private readonly array $applicableLetters,
        private readonly string $applicationMethodEnglish,
        private readonly string $applicationMethodUrdu,
        private readonly int $displayOrder,
        private readonly ?string $colorCode,
        private readonly ?array $examples,
        private readonly ?string $audioExplanation,
        private readonly int $difficultyLevel,
        private readonly bool $isBasic
    ) {}

    public static function create(
        string $ruleCategory,
        string $ruleNameEnglish,
        string $ruleNameArabic,
        string $ruleNameUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        array $applicableLetters,
        string $applicationMethodEnglish,
        string $applicationMethodUrdu,
        int $displayOrder,
        ?string $colorCode = null,
        ?array $examples = null,
        ?string $audioExplanation = null,
        int $difficultyLevel = 1,
        bool $isBasic = true
    ): self {
        return new self(
            $ruleCategory,
            $ruleNameEnglish,
            $ruleNameArabic,
            $ruleNameUrdu,
            $descriptionEnglish,
            $descriptionUrdu,
            $applicableLetters,
            $applicationMethodEnglish,
            $applicationMethodUrdu,
            $displayOrder,
            $colorCode,
            $examples,
            $audioExplanation,
            $difficultyLevel,
            $isBasic
        );
    }

    public function getRuleCategory(): string { return $this->ruleCategory; }
    public function getRuleNameEnglish(): string { return $this->ruleNameEnglish; }
    public function getRuleNameArabic(): string { return $this->ruleNameArabic; }
    public function getRuleNameUrdu(): string { return $this->ruleNameUrdu; }
    public function getDescriptionEnglish(): string { return $this->descriptionEnglish; }
    public function getDescriptionUrdu(): string { return $this->descriptionUrdu; }
    public function getApplicableLetters(): array { return $this->applicableLetters; }
    public function getApplicationMethodEnglish(): string { return $this->applicationMethodEnglish; }
    public function getApplicationMethodUrdu(): string { return $this->applicationMethodUrdu; }
    public function getDisplayOrder(): int { return $this->displayOrder; }
    public function getColorCode(): ?string { return $this->colorCode; }
    public function getExamples(): ?array { return $this->examples; }
    public function getAudioExplanation(): ?string { return $this->audioExplanation; }
    public function getDifficultyLevel(): int { return $this->difficultyLevel; }
    public function getIsBasic(): bool { return $this->isBasic; }
}
