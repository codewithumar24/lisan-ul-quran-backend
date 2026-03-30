<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\LessonDTO;

class LessonRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $lesson = $uuid ? app(LessonContract::class)->findByUuid($uuid) : null;

        return [
            'title_english' => ['required', 'string', 'max:255'],
            'title_urdu' => ['required', 'string', 'max:255'],
            'title_arabic' => ['nullable', 'string', 'max:255'],
            'description_english' => ['required', 'string'],
            'description_urdu' => ['required', 'string'],
            'lesson_type' => ['required', Rule::in(['alphabet', 'makhraj', 'tajweed_rule', 'practice', 'quiz'])],
            'chapter_number' => ['required', 'integer', 'min:1'],
            'lesson_number' => ['nullable', 'integer', 'min:1'],
            'content' => ['required', 'array'],
            'learning_objectives' => ['required', 'array'],
            'learning_objectives.*' => ['string'],
            'estimated_minutes' => ['required', 'integer', 'min:1'],
            'prerequisite_lessons' => ['nullable', 'array'],
            'prerequisite_lessons.*' => ['integer', 'exists:lessons,id'],
            'difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],
            'thumbnail_image' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:255'],
            'attachments' => ['nullable', 'array'],
            'is_published' => ['sometimes', 'boolean'],
            'arabic_letter_ids' => ['nullable', 'array'],
            'arabic_letter_ids.*' => ['integer', 'exists:arabic_letters,id'],
            'tajweed_rule_ids' => ['nullable', 'array'],
            'tajweed_rule_ids.*' => ['integer', 'exists:tajweed_rules,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title_english.required' => 'English title is required.',
            'title_urdu.required' => 'Urdu title is required.',
            'description_english.required' => 'English description is required.',
            'description_urdu.required' => 'Urdu description is required.',
            'lesson_type.required' => 'Lesson type is required.',
            'lesson_type.in' => 'Invalid lesson type selected.',
            'chapter_number.required' => 'Chapter number is required.',
            'content.required' => 'Lesson content is required.',
            'learning_objectives.required' => 'Learning objectives are required.',
            'estimated_minutes.required' => 'Estimated minutes is required.',
            'difficulty_level.required' => 'Difficulty level is required.',
        ];
    }

    public function getDTO(): LessonDTO
    {
        return LessonDTO::create(
            $this->input('title_english'),
            $this->input('title_urdu'),
            $this->input('title_arabic'),
            $this->input('description_english'),
            $this->input('description_urdu'),
            $this->input('lesson_type'),
            (int) $this->input('chapter_number'),
            (int) $this->input('lesson_number', 0),
            $this->input('content', []),
            $this->input('learning_objectives', []),
            (int) $this->input('estimated_minutes'),
            $this->input('prerequisite_lessons'),
            (int) $this->input('difficulty_level', 1),
            $this->input('thumbnail_image'),
            $this->input('video_url'),
            $this->input('attachments'),
            $this->boolean('is_published', false),
            null,
            $this->input('arabic_letter_ids', []),
            $this->input('tajweed_rule_ids', [])
        );
    }
}
