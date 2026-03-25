<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\TajweedRuleRepositoryContract;
use Modules\Admin\Contracts\Services\TajweedRuleContract;
use Modules\Admin\DataTransfer\Requests\TajweedRuleDTO;
use Modules\Admin\Entities\TajweedRule;

readonly class TajweedRuleService implements TajweedRuleContract
{
    public function __construct(
        private TajweedRuleRepositoryContract $tajweedRuleRepository
    ) {}

    public function create(TajweedRuleDTO $dto): TajweedRule
    {
        // Check if rule already exists
        if ($this->tajweedRuleRepository->existsByName($dto->getRuleNameEnglish())) {
            throw new \Exception("Tajweed rule '{$dto->getRuleNameEnglish()}' already exists.", 422);
        }

        return $this->tajweedRuleRepository->create(
            $dto->getRuleCategory(),
            $dto->getRuleNameEnglish(),
            $dto->getRuleNameArabic(),
            $dto->getRuleNameUrdu(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getApplicableLetters(),
            $dto->getApplicationMethodEnglish(),
            $dto->getApplicationMethodUrdu(),
            $dto->getDisplayOrder(),
            $dto->getColorCode(),
            $dto->getExamples(),
            $dto->getAudioExplanation(),
            $dto->getDifficultyLevel(),
            $dto->getIsBasic()
        );
    }

    public function update(TajweedRule $tajweedRule, TajweedRuleDTO $dto): TajweedRule
    {
        // Check if updating to a different name that already exists
        if ($dto->getRuleNameEnglish() !== $tajweedRule->rule_name_english) {
            if ($this->tajweedRuleRepository->existsByName($dto->getRuleNameEnglish(), $tajweedRule->id)) {
                throw new \Exception("Tajweed rule '{$dto->getRuleNameEnglish()}' already exists.", 422);
            }
        }

        return $this->tajweedRuleRepository->update(
            $tajweedRule,
            $dto->getRuleCategory(),
            $dto->getRuleNameEnglish(),
            $dto->getRuleNameArabic(),
            $dto->getRuleNameUrdu(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getApplicableLetters(),
            $dto->getApplicationMethodEnglish(),
            $dto->getApplicationMethodUrdu(),
            $dto->getDisplayOrder(),
            $dto->getColorCode(),
            $dto->getExamples(),
            $dto->getAudioExplanation(),
            $dto->getDifficultyLevel(),
            $dto->getIsBasic()
        );
    }

    public function delete(TajweedRule $tajweedRule): ?bool
    {
        // Check if rule is used in lessons before deleting
        if ($tajweedRule->lessons()->exists()) {
            throw new \Exception("Cannot delete rule because it is used in lessons.", 422);
        }

        return $this->tajweedRuleRepository->delete($tajweedRule);
    }

    public function findById(int $id): ?TajweedRule
    {
        return $this->tajweedRuleRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?TajweedRule
    {
        return $this->tajweedRuleRepository->findByUuid($uuid);
    }

    public function findByNameEnglish(string $ruleNameEnglish): ?TajweedRule
    {
        return $this->tajweedRuleRepository->findByNameEnglish($ruleNameEnglish);
    }

    public function getAll(
        ?int $perPage = null,
        ?string $ruleCategory = null,
        ?int $difficultyLevel = null,
        ?bool $isBasic = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        return $this->tajweedRuleRepository->getAll(
            $perPage,
            $ruleCategory,
            $difficultyLevel,
            $isBasic,
            $search
        );
    }

    public function getCategories(): Collection
    {
        return $this->tajweedRuleRepository->getCategories();
    }

    public function getByCategory(string $category): Collection
    {
        return $this->tajweedRuleRepository->getByCategory($category);
    }

    public function updateDisplayOrder(array $orderData): bool
    {
        return $this->tajweedRuleRepository->updateDisplayOrder($orderData);
    }
}
