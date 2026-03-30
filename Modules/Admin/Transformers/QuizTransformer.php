<?php

namespace Modules\Admin\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Entities\Quiz;

/** @mixin Quiz */
class QuizTransformer extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => [
                'english' => $this->title_english,
                'urdu' => $this->title_urdu,
            ],
            'description' => [
                'english' => $this->description_english,
                'urdu' => $this->description_urdu,
            ],
            'quiz_type' => $this->quiz_type,
            'lesson' => $this->whenLoaded('lesson', function () {
                return [
                    'id' => $this->lesson->id,
                    'uuid' => $this->lesson->uuid,
                    'title_english' => $this->lesson->title_english,
                    'identifier' => $this->lesson->identifier,
                ];
            }),
            'chapter_number' => $this->chapter_number,
            'time_limit_minutes' => $this->time_limit_minutes,
            'passing_score_percentage' => $this->passing_score_percentage,
            'total_questions' => $this->total_questions,
            'max_attempts' => $this->max_attempts,
            'show_answers_after' => $this->show_answers_after,
            'is_published' => $this->is_published,
            'display_order' => $this->display_order,
            'questions' => QuizQuestionTransformer::collection($this->whenLoaded('questions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
