<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\TajweedRuleRepositoryContract;
use Modules\Admin\Entities\TajweedRule;

readonly class TajweedRuleRepository implements TajweedRuleRepositoryContract
{
    public function __construct(
        private TajweedRule $model
    ) {}

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
    ): TajweedRule {
        return $this->model->newQuery()->create([
            'rule_category' => $ruleCategory,
            'rule_name_english' => $ruleNameEnglish,
            'rule_name_arabic' => $ruleNameArabic,
            'rule_name_urdu' => $ruleNameUrdu,
            'description_english' => $descriptionEnglish,
            'description_urdu' => $descriptionUrdu,
            'applicable_letters' => $applicableLetters,
            'application_method_english' => $applicationMethodEnglish,
            'application_method_urdu' => $applicationMethodUrdu,
            'display_order' => $displayOrder,
            'color_code' => $colorCode,
            'examples' => $examples,
            'audio_explanation' => $audioExplanation,
            'difficulty_level' => $difficultyLevel,
            'is_basic' => $isBasic,
        ]);
    }

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
    ): TajweedRule {
        if (!is_null($ruleCategory) && $tajweedRule->rule_category !== $ruleCategory) {
            $tajweedRule->rule_category = $ruleCategory;
        }
        if (!is_null($ruleNameEnglish) && $tajweedRule->rule_name_english !== $ruleNameEnglish) {
            $tajweedRule->rule_name_english = $ruleNameEnglish;
        }
        if (!is_null($ruleNameArabic) && $tajweedRule->rule_name_arabic !== $ruleNameArabic) {
            $tajweedRule->rule_name_arabic = $ruleNameArabic;
        }
        if (!is_null($ruleNameUrdu) && $tajweedRule->rule_name_urdu !== $ruleNameUrdu) {
            $tajweedRule->rule_name_urdu = $ruleNameUrdu;
        }
        if (!is_null($descriptionEnglish) && $tajweedRule->description_english !== $descriptionEnglish) {
            $tajweedRule->description_english = $descriptionEnglish;
        }
        if (!is_null($descriptionUrdu) && $tajweedRule->description_urdu !== $descriptionUrdu) {
            $tajweedRule->description_urdu = $descriptionUrdu;
        }
        if (!is_null($applicableLetters)) {
            $tajweedRule->applicable_letters = $applicableLetters;
        }
        if (!is_null($applicationMethodEnglish) && $tajweedRule->application_method_english !== $applicationMethodEnglish) {
            $tajweedRule->application_method_english = $applicationMethodEnglish;
        }
        if (!is_null($applicationMethodUrdu) && $tajweedRule->application_method_urdu !== $applicationMethodUrdu) {
            $tajweedRule->application_method_urdu = $applicationMethodUrdu;
        }
        if (!is_null($displayOrder) && $tajweedRule->display_order !== $displayOrder) {
            $tajweedRule->display_order = $displayOrder;
        }
        if (!is_null($colorCode)) {
            $tajweedRule->color_code = $colorCode;
        }
        if (!is_null($examples)) {
            $tajweedRule->examples = $examples;
        }
        if (!is_null($audioExplanation)) {
            $tajweedRule->audio_explanation = $audioExplanation;
        }
        if (!is_null($difficultyLevel) && $tajweedRule->difficulty_level !== $difficultyLevel) {
            $tajweedRule->difficulty_level = $difficultyLevel;
        }
        if (!is_null($isBasic) && $tajweedRule->is_basic !== $isBasic) {
            $tajweedRule->is_basic = $isBasic;
        }

        $tajweedRule->save();
        return $tajweedRule;
    }

    public function delete(TajweedRule $tajweedRule): bool
    {
        return $tajweedRule->delete();
    }

    public function findById(int $id): ?TajweedRule
    {
        return $this->model->newQuery()->find($id);
    }

    public function findByUuid(string $uuid): ?TajweedRule
    {
        return $this->model->newQuery()->where('uuid', $uuid)->first();
    }

    public function findByNameEnglish(string $ruleNameEnglish): ?TajweedRule
    {
        return $this->model->newQuery()->where('rule_name_english', $ruleNameEnglish)->first();
    }

    public function getAll(
        ?int $perPage = null,
        ?string $ruleCategory = null,
        ?int $difficultyLevel = null,
        ?bool $isBasic = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery();

        if ($ruleCategory) {
            $query->where('rule_category', $ruleCategory);
        }

        if (!is_null($difficultyLevel)) {
            $query->where('difficulty_level', $difficultyLevel);
        }

        if (!is_null($isBasic)) {
            $query->where('is_basic', $isBasic);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('rule_name_english', 'like', "%{$search}%")
                    ->orWhere('rule_name_arabic', 'like', "%{$search}%")
                    ->orWhere('rule_name_urdu', 'like', "%{$search}%")
                    ->orWhere('description_english', 'like', "%{$search}%")
                    ->orWhere('description_urdu', 'like', "%{$search}%");
            });
        }

        $query->orderBy('display_order');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getCategories(): Collection
    {
        return $this->model->newQuery()
            ->select('rule_category')
            ->distinct()
            ->orderBy('rule_category')
            ->pluck('rule_category');
    }

    public function getByCategory(string $category): Collection
    {
        return $this->model->newQuery()
            ->where('rule_category', $category)
            ->orderBy('display_order')
            ->get();
    }

    public function updateDisplayOrder(array $orderData): bool
    {
        foreach ($orderData as $item) {
            $this->model->newQuery()
                ->where('id', $item['id'])
                ->update(['display_order' => $item['display_order']]);
        }
        return true;
    }

    public function existsByName(string $ruleNameEnglish, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()->where('rule_name_english', $ruleNameEnglish);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
