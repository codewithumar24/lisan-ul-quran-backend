<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\ArabicLetterDTO;

class ArabicLetterRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $arabicLetter = $uuid ? app(ArabicLetterContract::class)->findByUuid($uuid) : null;

        return [
            'letter_arabic' => [
                'required',
                'string',
                'max:10',
                Rule::unique('arabic_letters', 'letter_arabic')->ignore($arabicLetter?->id)
            ],
            'letter_name_arabic' => ['required', 'string', 'max:255'],
            'letter_name_urdu' => ['required', 'string', 'max:255'],
            'letter_name_english' => ['required', 'string', 'max:255'],
            'makhraj_category' => ['required', 'string', 'max:100'],
            'makhraj_description_urdu' => ['required', 'string'],
            'makhraj_description_english' => ['required', 'string'],
            'pronunciation_tips_urdu' => ['required', 'string'],
            'pronunciation_tips_english' => ['required', 'string'],
            'shape_isolated' => ['required', 'string', 'max:50'],
            'display_order' => ['required', 'integer', 'min:1'],
            'audio_file_letter' => ['nullable', 'string', 'max:255'],
            'audio_file_makhraj' => ['nullable', 'string', 'max:255'],
            'shape_initial' => ['nullable', 'string', 'max:50'],
            'shape_middle' => ['nullable', 'string', 'max:50'],
            'shape_final' => ['nullable', 'string', 'max:50'],
            'similar_urdu_sounds' => ['nullable', 'array'],
            'similar_urdu_sounds.*' => ['string'],
            'common_mistakes_urdu' => ['nullable', 'array'],
            'common_mistakes_urdu.*' => ['string'],
            'common_mistakes_english' => ['nullable', 'array'],
            'common_mistakes_english.*' => ['string'],
            'has_ghunnah' => ['sometimes', 'boolean'],
            'is_qalqalah' => ['sometimes', 'boolean'],
            'is_madd_letter' => ['sometimes', 'boolean'],
            'makhraj_diagram' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'letter_arabic.required' => 'The Arabic letter is required.',
            'letter_arabic.unique' => 'This Arabic letter already exists.',
            'letter_name_arabic.required' => 'The Arabic letter name is required.',
            'letter_name_urdu.required' => 'The Urdu letter name is required.',
            'letter_name_english.required' => 'The English letter name is required.',
            'makhraj_category.required' => 'The makhraj category is required.',
            'makhraj_description_urdu.required' => 'The makhraj description in Urdu is required.',
            'makhraj_description_english.required' => 'The makhraj description in English is required.',
            'pronunciation_tips_urdu.required' => 'The pronunciation tips in Urdu are required.',
            'pronunciation_tips_english.required' => 'The pronunciation tips in English are required.',
            'shape_isolated.required' => 'The isolated shape is required.',
            'display_order.required' => 'The display order is required.',
            'display_order.integer' => 'Display order must be a number.',
        ];
    }

    public function getDTO(): ArabicLetterDTO
    {
        return ArabicLetterDTO::create(
            $this->input('letter_arabic'),
            $this->input('letter_name_arabic'),
            $this->input('letter_name_urdu'),
            $this->input('letter_name_english'),
            $this->input('makhraj_category'),
            $this->input('makhraj_description_urdu'),
            $this->input('makhraj_description_english'),
            $this->input('pronunciation_tips_urdu'),
            $this->input('pronunciation_tips_english'),
            $this->input('shape_isolated'),
            (int) $this->input('display_order'),
            $this->input('audio_file_letter'),
            $this->input('audio_file_makhraj'),
            $this->input('shape_initial'),
            $this->input('shape_middle'),
            $this->input('shape_final'),
            $this->input('similar_urdu_sounds'),
            $this->input('common_mistakes_urdu'),
            $this->input('common_mistakes_english'),
            $this->boolean('has_ghunnah', false),
            $this->boolean('is_qalqalah', false),
            $this->boolean('is_madd_letter', false),
            $this->input('makhraj_diagram')
        );
    }
}