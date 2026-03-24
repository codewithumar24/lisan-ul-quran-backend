<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\ArabicLetterDTO;
use Modules\Admin\Entities\ArabicLetter;

interface ArabicLetterContract
{
    /**
     * Create a new Arabic letter
     *
     * @param ArabicLetterDTO $dto
     * @return ArabicLetter
     */
    public function create(ArabicLetterDTO $dto): ArabicLetter;

    /**
     * Update an existing Arabic letter
     *
     * @param ArabicLetter $arabicLetter
     * @param ArabicLetterDTO $dto
     * @return ArabicLetter
     */
    public function update(ArabicLetter $arabicLetter, ArabicLetterDTO $dto): ArabicLetter;

    /**
     * Delete an Arabic letter
     *
     * @param ArabicLetter $arabicLetter
     * @return bool|null
     */
    public function delete(ArabicLetter $arabicLetter): ?bool;

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
     * Get all Arabic letters with filters
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
     * @param array $orderData
     * @return bool
     */
    public function updateDisplayOrder(array $orderData): bool;

    /**
     * Get all makhraj categories (for filter dropdown)
     *
     * @return Collection
     */
    public function getMakhrajCategories(): Collection;
}