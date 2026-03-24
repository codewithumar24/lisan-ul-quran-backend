<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\ArabicLetter;

interface ArabicLetterRepositoryContract
{
    /**
     * Create a new Arabic letter
     *
     * @param string $letterArabic
     * @param string $letterNameArabic
     * @param string $letterNameUrdu
     * @param string $letterNameEnglish
     * @param string $makhrajCategory
     * @param string $makhrajDescriptionUrdu
     * @param string $makhrajDescriptionEnglish
     * @param string $pronunciationTipsUrdu
     * @param string $pronunciationTipsEnglish
     * @param string $shapeIsolated
     * @param int $displayOrder
     * @param string|null $audioFileLetter
     * @param string|null $audioFileMakhraj
     * @param string|null $shapeInitial
     * @param string|null $shapeMiddle
     * @param string|null $shapeFinal
     * @param array|null $similarUrduSounds
     * @param array|null $commonMistakesUrdu
     * @param array|null $commonMistakesEnglish
     * @param bool $hasGhunnah
     * @param bool $isQalqalah
     * @param bool $isMaddLetter
     * @param string|null $makhrajDiagram
     * @return ArabicLetter
     */
    public function create(
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
    ): ArabicLetter;

    /**
     * Update an existing Arabic letter
     *
     * @param ArabicLetter $arabicLetter
     * @param string|null $letterArabic
     * @param string|null $letterNameArabic
     * @param string|null $letterNameUrdu
     * @param string|null $letterNameEnglish
     * @param string|null $makhrajCategory
     * @param string|null $makhrajDescriptionUrdu
     * @param string|null $makhrajDescriptionEnglish
     * @param string|null $pronunciationTipsUrdu
     * @param string|null $pronunciationTipsEnglish
     * @param string|null $shapeIsolated
     * @param int|null $displayOrder
     * @param string|null $audioFileLetter
     * @param string|null $audioFileMakhraj
     * @param string|null $shapeInitial
     * @param string|null $shapeMiddle
     * @param string|null $shapeFinal
     * @param array|null $similarUrduSounds
     * @param array|null $commonMistakesUrdu
     * @param array|null $commonMistakesEnglish
     * @param bool|null $hasGhunnah
     * @param bool|null $isQalqalah
     * @param bool|null $isMaddLetter
     * @param string|null $makhrajDiagram
     * @return ArabicLetter
     */
    public function update(
        ArabicLetter $arabicLetter,
        ?string $letterArabic = null,
        ?string $letterNameArabic = null,
        ?string $letterNameUrdu = null,
        ?string $letterNameEnglish = null,
        ?string $makhrajCategory = null,
        ?string $makhrajDescriptionUrdu = null,
        ?string $makhrajDescriptionEnglish = null,
        ?string $pronunciationTipsUrdu = null,
        ?string $pronunciationTipsEnglish = null,
        ?string $shapeIsolated = null,
        ?int $displayOrder = null,
        ?string $audioFileLetter = null,
        ?string $audioFileMakhraj = null,
        ?string $shapeInitial = null,
        ?string $shapeMiddle = null,
        ?string $shapeFinal = null,
        ?array $similarUrduSounds = null,
        ?array $commonMistakesUrdu = null,
        ?array $commonMistakesEnglish = null,
        ?bool $hasGhunnah = null,
        ?bool $isQalqalah = null,
        ?bool $isMaddLetter = null,
        ?string $makhrajDiagram = null
    ): ArabicLetter;

    /**
     * Delete an Arabic letter
     *
     * @param ArabicLetter $arabicLetter
     * @return bool
     */
    public function delete(ArabicLetter $arabicLetter): bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return ArabicLetter|null
     */
    public function findById(int $id): ?ArabicLetter;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return ArabicLetter|null
     */
    public function findByUuid(string $uuid): ?ArabicLetter;

    /**
     * Get all Arabic letters with optional filters
     *
     * @param int|null $perPage
     * @param string|null $makhrajCategory
     * @param bool|null $hasGhunnah
     * @param bool|null $isQalqalah
     * @param bool|null $isMaddLetter
     * @param string|null $search
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?string $makhrajCategory = null,
        ?bool $hasGhunnah = null,
        ?bool $isQalqalah = null,
        ?bool $isMaddLetter = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection;

    /**
     * Get letters by makhraj category
     *
     * @param string $category
     * @return Collection
     */
    public function getByMakhrajCategory(string $category): Collection;

    /**
     * Update display order
     *
     * @param array $orderData [['id' => 1, 'display_order' => 1], ...]
     * @return bool
     */
    public function updateDisplayOrder(array $orderData): bool;

    /**
     * Check if letter exists by Arabic character
     *
     * @param string $letterArabic
     * @param int|null $excludeId
     * @return bool
     */
    public function existsByLetter(string $letterArabic, ?int $excludeId = null): bool;
}