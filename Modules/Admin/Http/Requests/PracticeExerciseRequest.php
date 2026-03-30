<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\PracticeExerciseDTO;

class PracticeExerciseRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $exercise = $uuid ? app(PracticeExerciseContract::class)->findByUuid($uuid) : null;

        return [
            'lesson_id' => ['required', 'integer', 'exists:lessons,id'],
            'title_english' => [
                'required',
                'string',
                'max:255',
            ],
            'title_urdu' => ['required', 'string', 'max:255'],
            'exercise_type' => ['required', Rule::in([
                'repetition',
                'pronunciation',
                'identification',
                'listening',
                'recording'
            ])],
            'instructions_english' => ['required', 'string'],
            'instructions_urdu' => ['required', 'string'],
            'content' => ['required', 'array'],
            'correct_response' => ['nullable', 'array'],
            'options' => ['nullable', 'array'],
            'audio_prompt' => ['nullable', 'string', 'max:255'],
            'correct_audio' => ['nullable', 'string', 'max:255'],
            'points' => ['required', 'integer', 'min:1', 'max:100'],
            'difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],
            'display_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'lesson_id.required' => 'Lesson is required.',
            'title_english.required' => 'English title is required.',
            'title_urdu.required' => 'Urdu title is required.',
            'exercise_type.required' => 'Exercise type is required.',
            'exercise_type.in' => 'Invalid exercise type selected.',
            'instructions_english.required' => 'English instructions are required.',
            'instructions_urdu.required' => 'Urdu instructions are required.',
            'content.required' => 'Exercise content is required.',
            'points.required' => 'Points are required.',
            'difficulty_level.required' => 'Difficulty level is required.',
        ];
    }

    public function getDTO(): PracticeExerciseDTO
    {
        return PracticeExerciseDTO::create(
            (int) $this->input('lesson_id'),
            $this->input('title_english'),
            $this->input('title_urdu'),
            $this->input('exercise_type'),
            $this->input('instructions_english'),
            $this->input('instructions_urdu'),
            $this->input('content', []),
            (int) $this->input('points', 10),
            (int) $this->input('difficulty_level', 1),
            $this->input('correct_response'),
            $this->input('options'),
            $this->input('audio_prompt'),
            $this->input('correct_audio'),
            $this->input('display_order') ? (int) $this->input('display_order') : null
        );
    }
}
