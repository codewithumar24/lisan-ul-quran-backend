<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\QuizQuestion;

/** @mixin QuizQuestion */
class QuizQuestionTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'question' => [
                'english' => $this->question_english,
                'urdu' => $this->question_urdu,
            ],
            'question_type' => $this->question_type,
            'options' => $this->options,
            'correct_answers' => $this->correct_answers,
            'explanation' => [
                'english' => $this->explanation_english,
                'urdu' => $this->explanation_urdu,
            ],
            'audio_file' => $this->audio_file ? url('storage/' . $this->audio_file) : null,
            'image_file' => $this->image_file ? url('storage/' . $this->image_file) : null,
            'points' => $this->points,
            'difficulty_level' => $this->difficulty_level,
            'display_order' => $this->display_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
