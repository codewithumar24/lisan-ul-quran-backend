<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\MakhrajCategory;

/** @mixin MakhrajCategory */
class MakhrajCategoryTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => [
                'english' => $this->name_english,
                'arabic' => $this->name_arabic,
                'urdu' => $this->name_urdu,
            ],
            'description' => [
                'english' => $this->description_english,
                'urdu' => $this->description_urdu,
            ],
            'icon' => $this->icon ? url('storage/' . $this->icon) : null,
            'display_order' => $this->display_order,
            'arabic_letters_count' => $this->whenLoaded('arabicLetters', function () {
                return $this->arabicLetters->count();
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
