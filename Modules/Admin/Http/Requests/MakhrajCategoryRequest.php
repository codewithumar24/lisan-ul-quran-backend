<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Contracts\Services\MakhrajCategoryContract;
use Modules\Admin\DataTransfer\Requests\MakhrajCategoryDTO;

class MakhrajCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $category = $uuid ? app(MakhrajCategoryContract::class)->findByUuid($uuid) : null;

        return [
            'name_english' => [
                'required',
                'string',
                'max:255',
                Rule::unique('makharij_categories', 'name_english')->ignore($category?->id)
            ],
            'name_arabic' => ['required', 'string', 'max:255'],
            'name_urdu' => ['required', 'string', 'max:255'],
            'description_english' => ['required', 'string'],
            'description_urdu' => ['required', 'string'],
            'display_order' => ['required', 'integer', 'min:1'],
            'icon' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_english.required' => 'English name is required.',
            'name_english.unique' => 'This category name already exists.',
            'name_arabic.required' => 'Arabic name is required.',
            'name_urdu.required' => 'Urdu name is required.',
            'description_english.required' => 'English description is required.',
            'description_urdu.required' => 'Urdu description is required.',
            'display_order.required' => 'Display order is required.',
        ];
    }

    public function getDTO(): MakhrajCategoryDTO
    {
        return MakhrajCategoryDTO::create(
            $this->input('name_english'),
            $this->input('name_arabic'),
            $this->input('name_urdu'),
            $this->input('description_english'),
            $this->input('description_urdu'),
            (int) $this->input('display_order'),
            $this->input('icon')
        );
    }
}
