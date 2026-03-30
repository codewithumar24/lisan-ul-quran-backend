<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\QuizQuestionDTO;

class QuizQuestionRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $question = $uuid ? app(QuizQuestionContract::class)->findByUuid($uuid) : null;

        return [
            'quiz_id' => ['required', 'integer', 'exists:quizzes,id'],
            'question_english' => ['required', 'string'],
            'question_urdu' => ['required', 'string'],
            'question_type' => ['required', Rule::in([
                'multiple_choice',
                'true_false',
                'matching',
                'audio_identification',
                'pronunciation_check'
            ])],
            'options' => ['required', 'array'],
            'options.*' => ['required'],
            'correct_answers' => ['required', 'array'],
            'correct_answers.*' => ['required'],
            'explanation_english' => ['nullable', 'string'],
            'explanation_urdu' => ['nullable', 'string'],
            'audio_file' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'string', 'max:255'],
            'points' => ['required', 'integer', 'min:1', 'max:10'],
            'difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'quiz_id.required' => 'Quiz is required.',
            'question_english.required' => 'English question text is required.',
            'question_urdu.required' => 'Urdu question text is required.',
            'question_type.required' => 'Question type is required.',
            'options.required' => 'Options are required.',
            'correct_answers.required' => 'Correct answers are required.',
        ];
    }

    public function getDTO(): QuizQuestionDTO
    {
        return QuizQuestionDTO::create(
            (int) $this->input('quiz_id'),
            $this->input('question_english'),
            $this->input('question_urdu'),
            $this->input('question_type'),
            $this->input('options', []),
            $this->input('correct_answers', []),
            $this->input('display_order') ? (int) $this->input('display_order') : null,
            $this->input('explanation_english'),
            $this->input('explanation_urdu'),
            $this->input('audio_file'),
            $this->input('image_file'),
            (int) $this->input('points', 1),
            (int) $this->input('difficulty_level', 1)
        );
    }
}
