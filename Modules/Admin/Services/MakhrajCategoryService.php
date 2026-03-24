<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\MakhrajCategoryRepositoryContract;
use Modules\Admin\Contracts\Services\MakhrajCategoryContract;
use Modules\Admin\DataTransfer\Requests\MakhrajCategoryDTO;
use Modules\Admin\Entities\MakhrajCategory;

readonly class MakhrajCategoryService implements MakhrajCategoryContract
{
    public function __construct(
        private MakhrajCategoryRepositoryContract $makhrajCategoryRepository
    ) {}

    public function create(MakhrajCategoryDTO $dto): MakhrajCategory
    {
        // Check if category already exists
        if ($this->makhrajCategoryRepository->existsByName($dto->getNameEnglish())) {
            throw new \Exception("Makhraj category '{$dto->getNameEnglish()}' already exists.", 422);
        }

        return $this->makhrajCategoryRepository->create(
            $dto->getNameEnglish(),
            $dto->getNameArabic(),
            $dto->getNameUrdu(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getDisplayOrder(),
            $dto->getIcon()
        );
    }

    public function update(MakhrajCategory $makhrajCategory, MakhrajCategoryDTO $dto): MakhrajCategory
    {
        // Check if updating to a different name that already exists
        if ($dto->getNameEnglish() !== $makhrajCategory->name_english) {
            if ($this->makhrajCategoryRepository->existsByName($dto->getNameEnglish(), $makhrajCategory->id)) {
                throw new \Exception("Makhraj category '{$dto->getNameEnglish()}' already exists.", 422);
            }
        }

        return $this->makhrajCategoryRepository->update(
            $makhrajCategory,
            $dto->getNameEnglish(),
            $dto->getNameArabic(),
            $dto->getNameUrdu(),
            $dto->getDescriptionEnglish(),
            $dto->getDescriptionUrdu(),
            $dto->getDisplayOrder(),
            $dto->getIcon()
        );
    }

    public function delete(MakhrajCategory $makhrajCategory): ?bool
    {
        // Check if category has Arabic letters before deleting
        if ($makhrajCategory->arabicLetters()->exists()) {
            throw new \Exception("Cannot delete category because it has Arabic letters assigned to it.", 422);
        }

        return $this->makhrajCategoryRepository->delete($makhrajCategory);
    }

    public function findById(int $id): ?MakhrajCategory
    {
        return $this->makhrajCategoryRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?MakhrajCategory
    {
        return $this->makhrajCategoryRepository->findByUuid($uuid);
    }

    public function findByNameEnglish(string $nameEnglish): ?MakhrajCategory
    {
        return $this->makhrajCategoryRepository->findByNameEnglish($nameEnglish);
    }

    public function getAll(
        ?int $perPage = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        return $this->makhrajCategoryRepository->getAll($perPage, $search);
    }

    public function updateDisplayOrder(array $orderData): bool
    {
        return $this->makhrajCategoryRepository->updateDisplayOrder($orderData);
    }
}
