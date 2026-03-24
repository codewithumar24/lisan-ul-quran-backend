<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\MakhrajCategoryRepositoryContract;
use Modules\Admin\Entities\MakhrajCategory;

readonly class MakhrajCategoryRepository implements MakhrajCategoryRepositoryContract
{
    public function __construct(
        private MakhrajCategory $model
    ) {}

    public function create(
        string $nameEnglish,
        string $nameArabic,
        string $nameUrdu,
        string $descriptionEnglish,
        string $descriptionUrdu,
        int $displayOrder,
        ?string $icon = null
    ): MakhrajCategory {
        return $this->model->newQuery()->create([
            'name_english' => $nameEnglish,
            'name_arabic' => $nameArabic,
            'name_urdu' => $nameUrdu,
            'description_english' => $descriptionEnglish,
            'description_urdu' => $descriptionUrdu,
            'display_order' => $displayOrder,
            'icon' => $icon,
        ]);
    }

    public function update(
        MakhrajCategory $makhrajCategory,
        ?string $nameEnglish = null,
        ?string $nameArabic = null,
        ?string $nameUrdu = null,
        ?string $descriptionEnglish = null,
        ?string $descriptionUrdu = null,
        ?int $displayOrder = null,
        ?string $icon = null
    ): MakhrajCategory {
        if (!is_null($nameEnglish) && $makhrajCategory->name_english !== $nameEnglish) {
            $makhrajCategory->name_english = $nameEnglish;
        }
        if (!is_null($nameArabic) && $makhrajCategory->name_arabic !== $nameArabic) {
            $makhrajCategory->name_arabic = $nameArabic;
        }
        if (!is_null($nameUrdu) && $makhrajCategory->name_urdu !== $nameUrdu) {
            $makhrajCategory->name_urdu = $nameUrdu;
        }
        if (!is_null($descriptionEnglish) && $makhrajCategory->description_english !== $descriptionEnglish) {
            $makhrajCategory->description_english = $descriptionEnglish;
        }
        if (!is_null($descriptionUrdu) && $makhrajCategory->description_urdu !== $descriptionUrdu) {
            $makhrajCategory->description_urdu = $descriptionUrdu;
        }
        if (!is_null($displayOrder) && $makhrajCategory->display_order !== $displayOrder) {
            $makhrajCategory->display_order = $displayOrder;
        }
        if (!is_null($icon)) {
            $makhrajCategory->icon = $icon;
        }

        $makhrajCategory->save();
        return $makhrajCategory;
    }

    public function delete(MakhrajCategory $makhrajCategory): bool
    {
        return $makhrajCategory->delete();
    }

    public function findById(int $id): ?MakhrajCategory
    {
        return $this->model->newQuery()->find($id);
    }

    public function findByUuid(string $uuid): ?MakhrajCategory
    {
        return $this->model->newQuery()->where('uuid', $uuid)->first();
    }

    public function findByNameEnglish(string $nameEnglish): ?MakhrajCategory
    {
        return $this->model->newQuery()->where('name_english', $nameEnglish)->first();
    }

    public function getAll(
        ?int $perPage = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name_english', 'like', "%{$search}%")
                    ->orWhere('name_arabic', 'like', "%{$search}%")
                    ->orWhere('name_urdu', 'like', "%{$search}%")
                    ->orWhere('description_english', 'like', "%{$search}%")
                    ->orWhere('description_urdu', 'like', "%{$search}%");
            });
        }

        $query->orderBy('display_order');

        return $perPage ? $query->paginate($perPage) : $query->get();
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

    public function existsByName(string $nameEnglish, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()->where('name_english', $nameEnglish);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
