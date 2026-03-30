<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\Lesson;
use Modules\Admin\Transformers\ArabicLetterTransformer;
use Modules\Admin\Transformers\TajweedRuleTransformer;

/** @mixin Lesson */
class LessonTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'identifier' => $this->identifier,
            'display_title' => $this->display_title,
            'title' => [
                'english' => $this->title_english,
                'urdu' => $this->title_urdu,
                'arabic' => $this->title_arabic,
            ],
            'description' => [
                'english' => $this->description_english,
                'urdu' => $this->description_urdu,
            ],
            'lesson_type' => $this->lesson_type,
            'chapter_number' => $this->chapter_number,
            'lesson_number' => $this->lesson_number,
            'content' => $this->content,
            'learning_objectives' => $this->learning_objectives,
            'prerequisite_lessons' => $this->prerequisite_lessons,
            'estimated_minutes' => $this->estimated_minutes,
            'difficulty_level' => $this->difficulty_level,
            'thumbnail_image' => $this->thumbnail_image ? url('storage/' . $this->thumbnail_image) : null,
            'video_url' => $this->video_url,
            'attachments' => $this->attachments,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at,
            'arabic_letters' => ArabicLetterTransformer::collection($this->whenLoaded('arabicLetters')),
            'tajweed_rules' => TajweedRuleTransformer::collection($this->whenLoaded('tajweedRules')),
            'prerequisites' => LessonTransformer::collection($this->whenLoaded('prerequisites')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
