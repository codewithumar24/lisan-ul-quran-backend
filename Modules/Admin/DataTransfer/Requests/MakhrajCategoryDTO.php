<?php

namespace Modules\Admin\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class MakhrajCategoryDTO implements DTO
{
    public function __construct(
        private readonly string $nameEnglish,
        private readonly string $nameArabic,
        private readonly string $nameUrdu,
        private readonly string $descriptionEnglish,
        private readonly string $descriptionUrdu,
        private readonly int $displayOrder,
        private readonly ?string $icon
    ) {}

    public static function create(
        string $nameEnglish,
        string $nameArabic,
        string $nameUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        int $displayOrder,
        ?string $icon = null
    ): self {
        return new self(
            $nameEnglish,
            $nameArabic,
            $nameUrdu,
            $descriptionEnglish,
            $descriptionUrdu,
            $displayOrder,
            $icon
        );
    }

    public function getNameEnglish(): string { return $this->nameEnglish; }
    public function getNameArabic(): string { return $this->nameArabic; }
    public function getNameUrdu(): string { return $this->nameUrdu; }
    public function getDescriptionEnglish(): string { return $this->descriptionEnglish; }
    public function getDescriptionUrdu(): string { return $this->descriptionUrdu; }
    public function getDisplayOrder(): int { return $this->displayOrder; }
    public function getIcon(): ?string { return $this->icon; }
}
