<?php

namespace Modules\Admin\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Entities\TajweedRule;

interface TajweedRuleRepositoryContract
{
    /**
     * Create a new tajweed rule
     *
     * @param string $ruleCategory
     * @param string $ruleNameEnglish
     * @param string $ruleNameArabic
     * @param string $ruleNameUrdu
     * @param string $descriptionEnglish
     * @param string $descriptionUrdu
     * @param array $applicableLetters
     * @param string $applicationMethodEnglish
     * @param string $applicationMethodUrdu
     * @param int $displayOrder
     * @param string|null $colorCode
     * @param array|null $examples
     * @param string|null $audioExplanation
     * @param int $difficultyLevel
     * @param bool $isBasic
     * @return TajweedRule
     */
    public function create(
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
    ): TajweedRule;

    /**
     * Update an existing tajweed rule
     *
     * @param TajweedRule $tajweedRule
     * @param string|null $ruleCategory
     * @param string|null $ruleNameEnglish
     * @param string|null $ruleNameArabic
     * @param string|null $ruleNameUrdu
     * @param string|null $descriptionEnglish
     * @param string|null $descriptionUrdu
     * @param array|null $applicableLetters
     * @param string|null $applicationMethodEnglish
     * @param string|null $applicationMethodUrdu
     * @param int|null $displayOrder
     * @param string|null $colorCode
     * @param array|null $examples
     * @param string|null $audioExplanation
     * @param int|null $difficultyLevel
     * @param bool|null $isBasic
     * @return TajweedRule
     */
    public function update(
        TajweedRule $tajweedRule,
        ?string $ruleCategory = null,
        ?string $ruleNameEnglish = null,
        ?string $ruleNameArabic = null,
        ?string $ruleNameUrdu = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?array $applicableLetters = null,
        ?string $applicationMethodEnglish = null,
        ?string $applicationMethodUrdu = null,
        ?int $displayOrder = null,
        ?string $colorCode = null,
        ?array $examples = null,
        ?string $audioExplanation = null,
        ?int $difficultyLevel = null,
        ?bool $isBasic = null
    ): TajweedRule;

    /**
     * Delete a tajweed rule
     *
     * @param TajweedRule $tajweedRule
     * @return bool
     */
    public function delete(TajweedRule $tajweedRule): bool;

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

    /**
     * Check if rule exists by English name
     *
     * @param string $ruleNameEnglish
     * @param int|null $excludeId
     * @return bool
     */
    public function existsByName(string $ruleNameEnglish, ?int $excludeId = null): bool;
}
