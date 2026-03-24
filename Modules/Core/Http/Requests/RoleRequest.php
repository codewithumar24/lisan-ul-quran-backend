<?php

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Core\DataTransfer\Requests\RoleDTO;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($uuid, 'uuid')
            ],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Role name is required.',
            'name.unique' => 'This role name already exists.',
        ];
    }

    public function getDTO(): RoleDTO
    {
        return RoleDTO::create(
            $this->input('name'),
            $this->input('description'),
            $this->input('permissions', [])
        );
    }
}
