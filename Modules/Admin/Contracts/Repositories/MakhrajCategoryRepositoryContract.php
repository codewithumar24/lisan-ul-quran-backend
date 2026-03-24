<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\MakhrajCategory;

interface MakhrajCategoryRepositoryContract
{
    /**
     * Create a new makhraj category
     *
     * @param string $nameEnglish
     * @param string $nameArabic
     * @param string $nameUrdu
     * @param string $descriptionEnglish
     * @param string $descriptionUrdu
     * @param int $displayOrder
     * @param string|null $icon
     * @return MakhrajCategory
     */
    public function create(
        string $nameEnglish,
        string $nameArabic,
        string $nameUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        int $displayOrder,
        ?string $icon = null
    ): MakhrajCategory;

    /**
     * Update an existing makhraj category
     *
     * @param MakhrajCategory $makhrajCategory
     * @param string|null $nameEnglish
     * @param string|null $nameArabic
     * @param string|null $nameUrdu
     * @param string|null $descriptionEnglish
     * @param string|null $descriptionUrdu
     * @param int|null $displayOrder
     * @param string|null $icon
     * @return MakhrajCategory
     */
    public function update(
        MakhrajCategory $makhrajCategory,
        ?string $nameEnglish = null,
        ?string $nameArabic = null,
        ?string $nameUrdu = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?int $displayOrder = null,
        ?string $icon = null
    ): MakhrajCategory;

    /**
     * Delete a makhraj category
     *
     * @param MakhrajCategory $makhrajCategory
     * @return bool
     */
    public function delete(MakhrajCategory $makhrajCategory): bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return MakhrajCategory|null
     */
    public function findById(int $id): ?MakhrajCategory;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return MakhrajCategory|null
     */
    public function findByUuid(string $uuid): ?MakhrajCategory;

    /**
     * Find by English name
     *
     * @param string $nameEnglish
     * @return MakhrajCategory|null
     */
    public function findByNameEnglish(string $nameEnglish): ?MakhrajCategory;

    /**
     * Get all makhraj categories
     *
     * @param int|null $perPage
     * @param string|null $search
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection;

    /**
     * Update display order
     *
     * @param array $orderData [['id' => 1, 'display_order' => 1], ...]
     * @return bool
     */
    public function updateDisplayOrder(array $orderData): bool;

    /**
     * Check if category exists by English name
     *
     * @param string $nameEnglish
     * @param int|null $excludeId
     * @return bool
     */
    public function existsByName(string $nameEnglish, ?int $excludeId = null): bool;
}
