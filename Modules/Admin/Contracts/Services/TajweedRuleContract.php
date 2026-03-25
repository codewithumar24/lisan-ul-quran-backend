<?php

namespace Modules\Admin\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\DataTransfer\Requests\TajweedRuleDTO;
use Modules\Admin\Entities\TajweedRule;

interface TajweedRuleContract
{
    /**
     * Create a new tajweed rule
     *
     * @param TajweedRuleDTO $dto
     * @return TajweedRule
     */
    public function create(TajweedRuleDTO $dto): TajweedRule;

    /**
     * Update an existing tajweed rule
     *
     * @param TajweedRule $tajweedRule
     * @param TajweedRuleDTO $dto
     * @return TajweedRule
     */
    public function update(TajweedRule $tajweedRule, TajweedRuleDTO $dto): TajweedRule;

    /**
     * Delete a tajweed rule
     *
     * @param TajweedRule $tajweedRule
     * @return bool|null
     */
    public function delete(TajweedRule $tajweedRule): ?bool;

    /**
     * Find by ID
     *
     * @param int $id
     * @return TajweedRule|null
     */
    public function findById(int $id): ?TajweedRule;

    /**
     * Find by UUID
     *
     * @param string $uuid
     * @return TajweedRule|null
     */
    public function findByUuid(string $uuid): ?TajweedRule;

    /**
     * Find by English name
     *
     * @param string $ruleNameEnglish
     * @return TajweedRule|null
     */
    public function findByNameEnglish(string $ruleNameEnglish): ?TajweedRule;

    /**
     * Get all tajweed rules with filters
     *
     * @param int|null $perPage
     * @param string|null $ruleCategory
     * @param int|null $difficultyLevel
     * @param bool|null $isBasic
     * @param string|null $search
     * @return LengthAwarePaginator|Collection
     */
    public function getAll(
        ?int $perPage = null,
        ?string $ruleCategory = null,
        ?int $difficultyLevel = null,
        ?bool $isBasic = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection;

    /**
     * Get all rule categories
     *
     * @return Collection
     */
    public function getCategories(): Collection;

    /**
     * Get rules by category
     *
     * @param string $category
     * @return Collection
     */
    public function getByCategory(string $category): Collection;

    /**
     * Update display order
     *
     * @param array $orderData
     * @return bool
     */
    public function updateDisplayOrder(array $orderData): bool;
}
