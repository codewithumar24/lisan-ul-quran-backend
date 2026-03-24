<?php

namespace Modules\Admin\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\ArabicLetterRepositoryContract;
use Modules\Admin\Contracts\Services\ArabicLetterContract;
use Modules\Admin\DataTransfer\Requests\ArabicLetterDTO;
use Modules\Admin\Entities\ArabicLetter;

readonly class ArabicLetterService implements ArabicLetterContract
{
    public function __construct(
        private ArabicLetterRepositoryContract $arabicLetterRepository
    ) {}

    public function create(ArabicLetterDTO $dto): ArabicLetter
    {
        // Check if letter already exists
        if ($this->arabicLetterRepository->existsByLetter($dto->getLetterArabic())) {
            throw new \Exception("Arabic letter '{$dto->getLetterArabic()}' already exists.", 422);
        }

        return $this->arabicLetterRepository->create(
            $dto->getLetterArabic(),
            $dto->getLetterNameArabic(),
            $dto->getLetterNameUrdu(),
            $dto->getLetterNameEnglish(),
            $dto->getMakhrajCategory(),
            $dto->getMakhrajDescriptionUrdu(),
            $dto->getMakhrajDescriptionEnglish(),
            $dto->getPronunciationTipsUrdu(),
            $dto->getPronunciationTipsEnglish(),
            $dto->getShapeIsolated(),
            $dto->getDisplayOrder(),
            $dto->getAudioFileLetter(),
            $dto->getAudioFileMakhraj(),
            $dto->getShapeInitial(),
            $dto->getShapeMiddle(),
            $dto->getShapeFinal(),
            $dto->getSimilarUrduSounds(),
            $dto->getCommonMistakesUrdu(),
            $dto->getCommonMistakesEnglish(),
            $dto->getHasGhunnah(),
            $dto->getIsQalqalah(),
            $dto->getIsMaddLetter(),
            $dto->getMakhrajDiagram()
        );
    }

    public function update(ArabicLetter $arabicLetter, ArabicLetterDTO $dto): ArabicLetter
    {
        // Check if updating to a different letter that already exists
        if ($dto->getLetterArabic() !== $arabicLetter->letter_arabic) {
            if ($this->arabicLetterRepository->existsByLetter($dto->getLetterArabic(), $arabicLetter->id)) {
                throw new \Exception("Arabic letter '{$dto->getLetterArabic()}' already exists.", 422);
            }
        }

        return $this->arabicLetterRepository->update(
            $arabicLetter,
            $dto->getLetterArabic(),
            $dto->getLetterNameArabic(),
            $dto->getLetterNameUrdu(),
            $dto->getLetterNameEnglish(),
            $dto->getMakhrajCategory(),
            $dto->getMakhrajDescriptionUrdu(),
            $dto->getMakhrajDescriptionEnglish(),
            $dto->getPronunciationTipsUrdu(),
            $dto->getPronunciationTipsEnglish(),
            $dto->getShapeIsolated(),
            $dto->getDisplayOrder(),
            $dto->getAudioFileLetter(),
            $dto->getAudioFileMakhraj(),
            $dto->getShapeInitial(),
            $dto->getShapeMiddle(),
            $dto->getShapeFinal(),
            $dto->getSimilarUrduSounds(),
            $dto->getCommonMistakesUrdu(),
            $dto->getCommonMistakesEnglish(),
            $dto->getHasGhunnah(),
            $dto->getIsQalqalah(),
            $dto->getIsMaddLetter(),
            $dto->getMakhrajDiagram()
        );
    }

    public function delete(ArabicLetter $arabicLetter): ?bool
    {
        // Check if letter is used in lessons before deleting
        if ($arabicLetter->lessons()->exists()) {
            throw new \Exception("Cannot delete letter because it is used in lessons.", 422);
        }
        
        return $this->arabicLetterRepository->delete($arabicLetter);
    }

    public function findById(int $id): ?ArabicLetter
    {
        return $this->arabicLetterRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?ArabicLetter
    {
        return $this->arabicLetterRepository->findByUuid($uuid);
    }

    public function getAll(
        ?int $perPage = null,
        ?string $makhrajCategory = null,
        ?bool $hasGhunnah = null,
        ?bool $isQalqalah = null,
        ?bool $isMaddLetter = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        return $this->arabicLetterRepository->getAll(
            $perPage,
            $makhrajCategory,
            $hasGhunnah,
            $isQalqalah,
            $isMaddLetter,
            $search
        );
    }

    public function getByMakhrajCategory(string $category): Collection
    {
        return $this->arabicLetterRepository->getByMakhrajCategory($category);
    }

    public function updateDisplayOrder(array $orderData): bool
    {
        return $this->arabicLetterRepository->updateDisplayOrder($orderData);
    }

    public function getMakhrajCategories(): Collection
    {
        // This could come from a separate MakhrajCategory model
        // For now, returning distinct values from the table
        return collect([
            'Al-Jawf',
            'Al-Halq',
            'Al-Lisan',
            'Ash-Shafataan',
            'Al-Khayshoom',
        ]);
    }
}