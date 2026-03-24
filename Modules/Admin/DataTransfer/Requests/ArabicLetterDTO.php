<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class ArabicLetterDTO implements DTO
{
    public function __construct(
        private readonly string $letterArabic,
        private readonly string $letterNameArabic,
        private readonly string $letterNameUrdu,
        private readonly string $letterNameEnglish,
        private readonly string $makhrajCategory,
        private readonly string $makhrajDescriptionUrdu,
        private readonly string $makhrajDescriptionEnglish,
        private readonly string $pronunciationTipsUrdu,
        private readonly string $pronunciationTipsEnglish,
        private readonly string $shapeIsolated,
        private readonly int $displayOrder,
        private readonly ?string $audioFileLetter,
        private readonly ?string $audioFileMakhraj,
        private readonly ?string $shapeInitial,
        private readonly ?string $shapeMiddle,
        private readonly ?string $shapeFinal,
        private readonly ?array $similarUrduSounds,
        private readonly ?array $commonMistakesUrdu,
        private readonly ?array $commonMistakesEnglish,
        private readonly bool $hasGhunnah,
        private readonly bool $isQalqalah,
        private readonly bool $isMaddLetter,
        private readonly ?string $makhrajDiagram
    ) {}

    public static function create(
        string $letterArabic,
        string $letterNameArabic,
        string $letterNameUrdu,
        string $letterNameEnglish,
        string $makhrajCategory,
        string $makhrajDescriptionUrdu,
        string $makhrajDescriptionEnglish,
        string $pronunciationTipsUrdu,
        string $pronunciationTipsEnglish,
        string $shapeIsolated,
        int $displayOrder,
        ?string $audioFileLetter = null,
        ?string $audioFileMakhraj = null,
        ?string $shapeInitial = null,
        ?string $shapeMiddle = null,
        ?string $shapeFinal = null,
        ?array $similarUrduSounds = null,
        ?array $commonMistakesUrdu = null,
        ?array $commonMistakesEnglish = null,
        bool $hasGhunnah = false,
        bool $isQalqalah = false,
        bool $isMaddLetter = false,
        ?string $makhrajDiagram = null
    ): self {
        return new self(
            $letterArabic,
            $letterNameArabic,
            $letterNameUrdu,
            $letterNameEnglish,
            $makhrajCategory,
            $makhrajDescriptionUrdu,
            $makhrajDescriptionEnglish,
            $pronunciationTipsUrdu,
            $pronunciationTipsEnglish,
            $shapeIsolated,
            $displayOrder,
            $audioFileLetter,
            $audioFileMakhraj,
            $shapeInitial,
            $shapeMiddle,
            $shapeFinal,
            $similarUrduSounds,
            $commonMistakesUrdu,
            $commonMistakesEnglish,
            $hasGhunnah,
            $isQalqalah,
            $isMaddLetter,
            $makhrajDiagram
        );
    }

    // Getters
    public function getLetterArabic(): string { return $this->letterArabic; }
    public function getLetterNameArabic(): string { return $this->letterNameArabic; }
    public function getLetterNameUrdu(): string { return $this->letterNameUrdu; }
    public function getLetterNameEnglish(): string { return $this->letterNameEnglish; }
    public function getMakhrajCategory(): string { return $this->makhrajCategory; }
    public function getMakhrajDescriptionUrdu(): string { return $this->makhrajDescriptionUrdu; }
    public function getMakhrajDescriptionEnglish(): string { return $this->makhrajDescriptionEnglish; }
    public function getPronunciationTipsUrdu(): string { return $this->pronunciationTipsUrdu; }
    public function getPronunciationTipsEnglish(): string { return $this->pronunciationTipsEnglish; }
    public function getShapeIsolated(): string { return $this->shapeIsolated; }
    public function getDisplayOrder(): int { return $this->displayOrder; }
    public function getAudioFileLetter(): ?string { return $this->audioFileLetter; }
    public function getAudioFileMakhraj(): ?string { return $this->audioFileMakhraj; }
    public function getShapeInitial(): ?string { return $this->shapeInitial; }
    public function getShapeMiddle(): ?string { return $this->shapeMiddle; }
    public function getShapeFinal(): ?string { return $this->shapeFinal; }
    public function getSimilarUrduSounds(): ?array { return $this->similarUrduSounds; }
    public function getCommonMistakesUrdu(): ?array { return $this->commonMistakesUrdu; }
    public function getCommonMistakesEnglish(): ?array { return $this->commonMistakesEnglish; }
    public function getHasGhunnah(): bool { return $this->hasGhunnah; }
    public function getIsQalqalah(): bool { return $this->isQalqalah; }
    public function getIsMaddLetter(): bool { return $this->isMaddLetter; }
    public function getMakhrajDiagram(): ?string { return $this->makhrajDiagram; }
}