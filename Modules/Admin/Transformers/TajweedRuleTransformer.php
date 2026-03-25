<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\TajweedRule;

/** @mixin TajweedRule */
class TajweedRuleTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'rule_category' => $this->rule_category,
            'rule_name' => [
                'english' => $this->rule_name_english,
                'arabic' => $this->rule_name_arabic,
                'urdu' => $this->rule_name_urdu,
            ],
            'description' => [
                'english' => $this->description_english,
                'urdu' => $this->description_urdu,
            ],
            'color_code' => $this->color_code,
            'applicable_letters' => $this->applicable_letters,
            'application_method' => [
                'english' => $this->application_method_english,
                'urdu' => $this->application_method_urdu,
            ],
            'examples' => $this->examples,
            'audio_explanation' => $this->audio_explanation ? url('storage/' . $this->audio_explanation) : null,
            'difficulty_level' => $this->difficulty_level,
            'display_order' => $this->display_order,
            'is_basic' => $this->is_basic,
            'lessons_count' => $this->whenLoaded('lessons', function () {
                return $this->lessons->count();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
