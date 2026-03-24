<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\ArabicLetter;

/** @mixin ArabicLetter */
class ArabicLetterTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'letter_arabic' => $this->letter_arabic,
            'letter_name_arabic' => $this->letter_name_arabic,
            'letter_name_urdu' => $this->letter_name_urdu,
            'letter_name_english' => $this->letter_name_english,
            'makhraj_category' => $this->makhraj_category,
            'makhraj_description' => [
                'urdu' => $this->makhraj_description_urdu,
                'english' => $this->makhraj_description_english,
            ],
            'pronunciation_tips' => [
                'urdu' => $this->pronunciation_tips_urdu,
                'english' => $this->pronunciation_tips_english,
            ],
            'audio_files' => [
                'letter' => $this->audio_file_letter ? url('storage/' . $this->audio_file_letter) : null,
                'makhraj' => $this->audio_file_makhraj ? url('storage/' . $this->audio_file_makhraj) : null,
            ],
            'shapes' => [
                'isolated' => $this->shape_isolated,
                'initial' => $this->shape_initial,
                'middle' => $this->shape_middle,
                'final' => $this->shape_final,
            ],
            'display_order' => $this->display_order,
            'similar_urdu_sounds' => $this->similar_urdu_sounds,
            'common_mistakes' => [
                'urdu' => $this->common_mistakes_urdu,
                'english' => $this->common_mistakes_english,
            ],
            'tajweed_properties' => [
                'has_ghunnah' => $this->has_ghunnah,
                'is_qalqalah' => $this->is_qalqalah,
                'is_madd_letter' => $this->is_madd_letter,
            ],
            'makhraj_diagram' => $this->makhraj_diagram ? url('storage/' . $this->makhraj_diagram) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}