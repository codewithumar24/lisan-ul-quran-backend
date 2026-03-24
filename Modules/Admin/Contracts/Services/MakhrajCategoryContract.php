<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\MakhrajCategoryDTO;
use Modules\Admin\Entities\MakhrajCategory;

interface MakhrajCategoryContract
{
    /**
     * Create a new makhraj category
     *
     * @param MakhrajCategoryDTO $dto
     * @return MakhrajCategory
     */
    public function create(MakhrajCategoryDTO $dto): MakhrajCategory;

    /**
     * Update an existing makhraj category
     *
     * @param MakhrajCategory $makhrajCategory
     * @param MakhrajCategoryDTO $dto
     * @return MakhrajCategory
     */
    public function update(MakhrajCategory $makhrajCategory, MakhrajCategoryDTO $dto): MakhrajCategory;

    /**
     * Delete a makhraj category
     *
     * @param MakhrajCategory $makhrajCategory
     * @return bool|null
     */
    public function delete(MakhrajCategory $makhrajCategory): ?bool;

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
     * @param array $orderData
     * @return bool
     */
    public function updateDisplayOrder(array $orderData): bool;
}
