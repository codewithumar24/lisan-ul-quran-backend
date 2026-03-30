<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\QuizDTO;

class QuizRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $quiz = $uuid ? app(QuizContract::class)->findByUuid($uuid) : null;

        return [
            'title_english' => [
                'required',
                'string',
                'max:255',
            ],
            'title_urdu' => ['required', 'string', 'max:255'],
            'description_english' => ['required', 'string'],
            'description_urdu' => ['required', 'string'],
            'quiz_type' => ['required', Rule::in(['lesson_quiz', 'chapter_quiz', 'final_assessment'])],
            'lesson_id' => ['nullable', 'required_if:quiz_type,lesson_quiz', 'integer', 'exists:lessons,id'],
            'chapter_number' => ['nullable', 'required_if:quiz_type,chapter_quiz', 'integer', 'min:1'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1'],
            'passing_score_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'max_attempts' => ['required', 'integer', 'min:1', 'max:10'],
            'show_answers_after' => ['sometimes', 'boolean'],
            'is_published' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'title_english.required' => 'English title is required.',
            'title_urdu.required' => 'Urdu title is required.',
            'description_english.required' => 'English description is required.',
            'description_urdu.required' => 'Urdu description is required.',
            'quiz_type.required' => 'Quiz type is required.',
            'lesson_id.required_if' => 'Lesson is required for lesson quiz.',
            'chapter_number.required_if' => 'Chapter number is required for chapter quiz.',
        ];
    }

    public function getDTO(): QuizDTO
    {
        return QuizDTO::create(
            $this->input('title_english'),
            $this->input('title_urdu'),
            $this->input('description_english'),
            $this->input('description_urdu'),
            $this->input('quiz_type'),
            $this->input('lesson_id') ? (int) $this->input('lesson_id') : null,
            $this->input('chapter_number') ? (int) $this->input('chapter_number') : null,
            $this->input('time_limit_minutes') ? (int) $this->input('time_limit_minutes') : null,
            (int) $this->input('passing_score_percentage', 70),
            (int) $this->input('max_attempts', 3),
            $this->boolean('show_answers_after', true),
            $this->boolean('is_published', false),
            $this->input('display_order') ? (int) $this->input('display_order') : null
        );
    }
}
