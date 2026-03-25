<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\DataTransfer\Requests\TajweedRuleDTO;

class TajweedRuleRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $rule = $uuid ? app(TajweedRuleContract::class)->findByUuid($uuid) : null;

        return [
            'rule_category' => ['required', 'string', 'max:255'],
            'rule_name_english' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tajweed_rules', 'rule_name_english')->ignore($rule?->id)
            ],
            'rule_name_arabic' => ['required', 'string', 'max:255'],
            'rule_name_urdu' => ['required', 'string', 'max:255'],
            'description_english' => ['required', 'string'],
            'description_urdu' => ['required', 'string'],
            'applicable_letters' => ['required', 'array'],
            'applicable_letters.*' => ['string'],
            'application_method_english' => ['required', 'string'],
            'application_method_urdu' => ['required', 'string'],
            'display_order' => ['required', 'integer', 'min:1'],
            'color_code' => ['nullable', 'string', 'max:50'],
            'examples' => ['nullable', 'array'],
            'examples.*' => ['string'],
            'audio_explanation' => ['nullable', 'string', 'max:255'],
            'difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],
            'is_basic' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'rule_category.required' => 'Rule category is required.',
            'rule_name_english.required' => 'English rule name is required.',
            'rule_name_english.unique' => 'This rule name already exists.',
            'rule_name_arabic.required' => 'Arabic rule name is required.',
            'rule_name_urdu.required' => 'Urdu rule name is required.',
            'description_english.required' => 'English description is required.',
            'description_urdu.required' => 'Urdu description is required.',
            'applicable_letters.required' => 'Applicable letters are required.',
            'application_method_english.required' => 'English application method is required.',
            'application_method_urdu.required' => 'Urdu application method is required.',
            'display_order.required' => 'Display order is required.',
            'difficulty_level.required' => 'Difficulty level is required.',
        ];
    }

    public function getDTO(): TajweedRuleDTO
    {
        return TajweedRuleDTO::create(
            $this->input('rule_category'),
            $this->input('rule_name_english'),
            $this->input('rule_name_arabic'),
            $this->input('rule_name_urdu'),
            $this->input('description_english'),
            $this->input('description_urdu'),
            $this->input('applicable_letters', []),
            $this->input('application_method_english'),
            $this->input('application_method_urdu'),
            (int) $this->input('display_order'),
            $this->input('color_code'),
            $this->input('examples'),
            $this->input('audio_explanation'),
            (int) $this->input('difficulty_level', 1),
            $this->boolean('is_basic', true)
        );
    }
}
