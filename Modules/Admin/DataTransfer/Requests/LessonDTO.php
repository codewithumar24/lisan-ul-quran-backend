<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class LessonDTO implements DTO
{
    public function __construct(
        private readonly string $titleEnglish,
        private readonly string $titleUrdu,
        private readonly ?string $titleArabic,
        private readonly string $descriptionEnglish,
        private readonly string $descriptionUrdu,
        private readonly string $lessonType,
        private readonly int $chapterNumber,
        private readonly int $lessonNumber,
        private readonly array $content,
        private readonly array $learningObjectives,
        private readonly int $estimatedMinutes,
        private readonly ?array $prerequisiteLessons,
        private readonly int $difficultyLevel,
        private readonly ?string $thumbnailImage,
        private readonly ?string $videoUrl,
        private readonly ?array $attachments,
        private readonly bool $isPublished,
        private readonly ?string $publishedAt,
        private readonly array $arabicLetterIds,
        private readonly array $tajweedRuleIds
    ) {}

    public static function create(
        string $titleEnglish,
        string $titleUrdu,
        ?string $titleArabic,
        string $descriptionEnglish,
        string $descriptionUrdu,
        string $lessonType,
        int $chapterNumber,
        int $lessonNumber,
        array $content,
        array $learningObjectives,
        int $estimatedMinutes,
        ?array $prerequisiteLessons = null,
        int $difficultyLevel = 1,
        ?string $thumbnailImage = null,
        ?string $videoUrl = null,
        ?array $attachments = null,
        bool $isPublished = false,
        ?string $publishedAt = null,
        array $arabicLetterIds = [],
        array $tajweedRuleIds = []
    ): self {
        return new self(
            $titleEnglish,
            $titleUrdu,
            $titleArabic,
            $descriptionEnglish,
            $descriptionUrdu,
            $lessonType,
            $chapterNumber,
            $lessonNumber,
            $content,
            $learningObjectives,
            $estimatedMinutes,
            $prerequisiteLessons,
            $difficultyLevel,
            $thumbnailImage,
            $videoUrl,
            $attachments,
            $isPublished,
            $publishedAt,
            $arabicLetterIds,
            $tajweedRuleIds
        );
    }

    public function getTitleEnglish(): string { return $this->titleEnglish; }
    public function getTitleUrdu(): string { return $this->titleUrdu; }
    public function getTitleArabic(): ?string { return $this->titleArabic; }
    public function getDescriptionEnglish(): string { return $this->descriptionEnglish; }
    public function getDescriptionUrdu(): string { return $this->descriptionUrdu; }
    public function getLessonType(): string { return $this->lessonType; }
    public function getChapterNumber(): int { return $this->chapterNumber; }
    public function getLessonNumber(): int { return $this->lessonNumber; }
    public function getContent(): array { return $this->content; }
    public function getLearningObjectives(): array { return $this->learningObjectives; }
    public function getEstimatedMinutes(): int { return $this->estimatedMinutes; }
    public function getPrerequisiteLessons(): ?array { return $this->prerequisiteLessons; }
    public function getDifficultyLevel(): int { return $this->difficultyLevel; }
    public function getThumbnailImage(): ?string { return $this->thumbnailImage; }
    public function getVideoUrl(): ?string { return $this->videoUrl; }
    public function getAttachments(): ?array { return $this->attachments; }
    public function getIsPublished(): bool { return $this->isPublished; }
    public function getPublishedAt(): ?string { return $this->publishedAt; }
    public function getArabicLetterIds(): array { return $this->arabicLetterIds; }
    public function getTajweedRuleIds(): array { return $this->tajweedRuleIds; }
}
