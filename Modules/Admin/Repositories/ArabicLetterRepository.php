<?php

namespace Modules\Admin\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Admin\Contracts\Repositories\ArabicLetterRepositoryContract;
use Modules\Admin\Entities\ArabicLetter;

readonly class ArabicLetterRepository implements ArabicLetterRepositoryContract
{
    public function __construct(
        private ArabicLetter $model
    ) {}

    public function create(
        string $letterArabic,
        string $letterNameArabic,
        string $letterNameUrdu,
        string $letterNameEnglish,
        string $makhrajCategory,
        string $makhrajDescriptionUrdu,
        string $makhrajDescriptionEnglish,
        string $pronunciationTipsUrdu,
        string $pronunciationTipsEnglish,
        string $shapeIsolated,
        int $displayOrder,
        ?string $audioFileLetter = null,
        ?string $audioFileMakhraj = null,
        ?string $shapeInitial = null,
        ?string $shapeMiddle = null,
        ?string $shapeFinal = null,
        ?array $similarUrduSounds = null,
        ?array $commonMistakesUrdu = null,
        ?array $commonMistakesEnglish = null,
        bool $hasGhunnah = false,
        bool $isQalqalah = false,
        bool $isMaddLetter = false,
        ?string $makhrajDiagram = null
    ): ArabicLetter {
        return $this->model->newQuery()->create([
            'letter_arabic' => $letterArabic,
            'letter_name_arabic' => $letterNameArabic,
            'letter_name_urdu' => $letterNameUrdu,
            'letter_name_english' => $letterNameEnglish,
            'makhraj_category' => $makhrajCategory,
            'makhraj_description_urdu' => $makhrajDescriptionUrdu,
            'makhraj_description_english' => $makhrajDescriptionEnglish,
            'pronunciation_tips_urdu' => $pronunciationTipsUrdu,
            'pronunciation_tips_english' => $pronunciationTipsEnglish,
            'shape_isolated' => $shapeIsolated,
            'display_order' => $displayOrder,
            'audio_file_letter' => $audioFileLetter,
            'audio_file_makhraj' => $audioFileMakhraj,
            'shape_initial' => $shapeInitial,
            'shape_middle' => $shapeMiddle,
            'shape_final' => $shapeFinal,
            'similar_urdu_sounds' => $similarUrduSounds,
            'common_mistakes_urdu' => $commonMistakesUrdu,
            'common_mistakes_english' => $commonMistakesEnglish,
            'has_ghunnah' => $hasGhunnah,
            'is_qalqalah' => $isQalqalah,
            'is_madd_letter' => $isMaddLetter,
            'makhraj_diagram' => $makhrajDiagram,
        ]);
    }

    public function update(
        ArabicLetter $arabicLetter,
        ?string $letterArabic = null,
        ?string $letterNameArabic = null,
        ?string $letterNameUrdu = null,
        ?string $letterNameEnglish = null,
        ?string $makhrajCategory = null,
        ?string $makhrajDescriptionUrdu = null,
        ?string $makhrajDescriptionEnglish = null,
        ?string $pronunciationTipsUrdu = null,
        ?string $pronunciationTipsEnglish = null,
        ?string $shapeIsolated = null,
        ?int $displayOrder = null,
        ?string $audioFileLetter = null,
        ?string $audioFileMakhraj = null,
        ?string $shapeInitial = null,
        ?string $shapeMiddle = null,
        ?string $shapeFinal = null,
        ?array $similarUrduSounds = null,
        ?array $commonMistakesUrdu = null,
        ?array $commonMistakesEnglish = null,
        ?bool $hasGhunnah = null,
        ?bool $isQalqalah = null,
        ?bool $isMaddLetter = null,
        ?string $makhrajDiagram = null
    ): ArabicLetter {
        if (!is_null($letterArabic) && $arabicLetter->letter_arabic !== $letterArabic) {
            $arabicLetter->letter_arabic = $letterArabic;
        }
        if (!is_null($letterNameArabic) && $arabicLetter->letter_name_arabic !== $letterNameArabic) {
            $arabicLetter->letter_name_arabic = $letterNameArabic;
        }
        if (!is_null($letterNameUrdu) && $arabicLetter->letter_name_urdu !== $letterNameUrdu) {
            $arabicLetter->letter_name_urdu = $letterNameUrdu;
        }
        if (!is_null($letterNameEnglish) && $arabicLetter->letter_name_english !== $letterNameEnglish) {
            $arabicLetter->letter_name_english = $letterNameEnglish;
        }
        if (!is_null($makhrajCategory) && $arabicLetter->makhraj_category !== $makhrajCategory) {
            $arabicLetter->makhraj_category = $makhrajCategory;
        }
        if (!is_null($makhrajDescriptionUrdu) && $arabicLetter->makhraj_description_urdu !== $makhrajDescriptionUrdu) {
            $arabicLetter->makhraj_description_urdu = $makhrajDescriptionUrdu;
        }
        if (!is_null($makhrajDescriptionEnglish) && $arabicLetter->makhraj_description_english !== $makhrajDescriptionEnglish) {
            $arabicLetter->makhraj_description_english = $makhrajDescriptionEnglish;
        }
        if (!is_null($pronunciationTipsUrdu) && $arabicLetter->pronunciation_tips_urdu !== $pronunciationTipsUrdu) {
            $arabicLetter->pronunciation_tips_urdu = $pronunciationTipsUrdu;
        }
        if (!is_null($pronunciationTipsEnglish) && $arabicLetter->pronunciation_tips_english !== $pronunciationTipsEnglish) {
            $arabicLetter->pronunciation_tips_english = $pronunciationTipsEnglish;
        }
        if (!is_null($shapeIsolated) && $arabicLetter->shape_isolated !== $shapeIsolated) {
            $arabicLetter->shape_isolated = $shapeIsolated;
        }
        if (!is_null($displayOrder) && $arabicLetter->display_order !== $displayOrder) {
            $arabicLetter->display_order = $displayOrder;
        }
        if (!is_null($audioFileLetter)) {
            $arabicLetter->audio_file_letter = $audioFileLetter;
        }
        if (!is_null($audioFileMakhraj)) {
            $arabicLetter->audio_file_makhraj = $audioFileMakhraj;
        }
        if (!is_null($shapeInitial)) {
            $arabicLetter->shape_initial = $shapeInitial;
        }
        if (!is_null($shapeMiddle)) {
            $arabicLetter->shape_middle = $shapeMiddle;
        }
        if (!is_null($shapeFinal)) {
            $arabicLetter->shape_final = $shapeFinal;
        }
        if (!is_null($similarUrduSounds)) {
            $arabicLetter->similar_urdu_sounds = $similarUrduSounds;
        }
        if (!is_null($commonMistakesUrdu)) {
            $arabicLetter->common_mistakes_urdu = $commonMistakesUrdu;
        }
        if (!is_null($commonMistakesEnglish)) {
            $arabicLetter->common_mistakes_english = $commonMistakesEnglish;
        }
        if (!is_null($hasGhunnah) && $arabicLetter->has_ghunnah !== $hasGhunnah) {
            $arabicLetter->has_ghunnah = $hasGhunnah;
        }
        if (!is_null($isQalqalah) && $arabicLetter->is_qalqalah !== $isQalqalah) {
            $arabicLetter->is_qalqalah = $isQalqalah;
        }
        if (!is_null($isMaddLetter) && $arabicLetter->is_madd_letter !== $isMaddLetter) {
            $arabicLetter->is_madd_letter = $isMaddLetter;
        }
        if (!is_null($makhrajDiagram)) {
            $arabicLetter->makhraj_diagram = $makhrajDiagram;
        }

        $arabicLetter->save();
        return $arabicLetter;
    }

    public function delete(ArabicLetter $arabicLetter): bool
    {
        return $arabicLetter->delete();
    }

    public function findById(int $id): ?ArabicLetter
    {
        return $this->model->newQuery()->find($id);
    }

    public function findByUuid(string $uuid): ?ArabicLetter
    {
        return $this->model->newQuery()->where('uuid', $uuid)->first();
    }

    public function getAll(
        ?int $perPage = null,
        ?string $makhrajCategory = null,
        ?bool $hasGhunnah = null,
        ?bool $isQalqalah = null,
        ?bool $isMaddLetter = null,
        ?string $search = null
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery();

        if ($makhrajCategory) {
            $query->where('makhraj_category', $makhrajCategory);
        }

        if (!is_null($hasGhunnah)) {
            $query->where('has_ghunnah', $hasGhunnah);
        }

        if (!is_null($isQalqalah)) {
            $query->where('is_qalqalah', $isQalqalah);
        }

        if (!is_null($isMaddLetter)) {
            $query->where('is_madd_letter', $isMaddLetter);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('letter_name_english', 'like', "%{$search}%")
                    ->orWhere('letter_name_urdu', 'like', "%{$search}%")
                    ->orWhere('letter_name_arabic', 'like', "%{$search}%")
                    ->orWhere('letter_arabic', 'like', "%{$search}%");
            });
        }

        $query->orderBy('display_order');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getByMakhrajCategory(string $category): Collection
    {
        return $this->model->newQuery()
            ->where('makhraj_category', $category)
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

    public function existsByLetter(string $letterArabic, ?int $excludeId = null): bool
    {
        $query = $this->model->newQuery()->where('letter_arabic', $letterArabic);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->exists();
    }
}