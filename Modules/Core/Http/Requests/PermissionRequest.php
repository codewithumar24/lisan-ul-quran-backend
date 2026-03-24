<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\DataTransfer\Requests\PermissionDTO;

class PermissionRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($uuid, 'uuid')
            ],
            'group' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Permission name is required.',
            'name.unique' => 'This permission name already exists.',
        ];
    }

    public function getDTO(): PermissionDTO
    {
        return PermissionDTO::create(
            $this->input('name'),
            $this->input('group'),
            $this->input('description')
        );
    }
}
