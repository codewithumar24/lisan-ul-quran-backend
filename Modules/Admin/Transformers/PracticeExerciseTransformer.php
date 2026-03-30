<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\PracticeExercise;

/** @mixin PracticeExercise */
class PracticeExerciseTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'lesson' => [
                'id' => $this->lesson->id,
                'uuid' => $this->lesson->uuid,
                'title_english' => $this->lesson->title_english,
                'identifier' => $this->lesson->identifier,
            ],
            'title' => [
                'english' => $this->title_english,
                'urdu' => $this->title_urdu,
            ],
            'exercise_type' => $this->exercise_type,
            'instructions' => [
                'english' => $this->instructions_english,
                'urdu' => $this->instructions_urdu,
            ],
            'content' => $this->content,
            'correct_response' => $this->correct_response,
            'options' => $this->options,
            'audio_files' => [
                'prompt' => $this->audio_prompt ? url('storage/' . $this->audio_prompt) : null,
                'correct' => $this->correct_audio ? url('storage/' . $this->correct_audio) : null,
            ],
            'points' => $this->points,
            'difficulty_level' => $this->difficulty_level,
            'display_order' => $this->display_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
