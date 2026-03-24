<?php

namespace Modules\User\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\DataTransfer\Requests\UserDTO;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        $uuid = $this->route('uuid');
        $userId = $uuid ? $this->userService->findByUuid($uuid)?->id : null;

        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'role_id' => ['required', 'exists:roles,id'],
            'cnic' => [
                'nullable',
                'string',
                Rule::unique('users', 'cnic')->ignore($userId)
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'student_type' => ['nullable', Rule::in(['military', 'civilian'])],
            'is_active' => ['sometimes', 'boolean'],
        ];

        // Password is required for create, optional for update
        if ($this->isMethod('POST')) {
            $rules['password'] = ['required', 'string', 'min:8'];
        } else {
            $rules['password'] = ['nullable', 'string', 'min:8'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already registered.',
            'role_id.required' => 'Role is required.',
            'cnic.unique' => 'This CNIC is already registered.',
        ];
    }

    public function getDTO(): UserDTO
    {
        return UserDTO::create(
            $this->input('first_name'),
            $this->input('last_name'),
            $this->input('email'),
            $this->input('password'),
            (int) $this->input('role_id'),
            $this->input('cnic'),
            $this->input('phone'),
            $this->input('date_of_birth'),
            $this->input('gender'),
            $this->input('country'),
            $this->input('city'),
            $this->input('address'),
            $this->input('student_type'),
            $this->boolean('is_active', true)
        );
    }
}
