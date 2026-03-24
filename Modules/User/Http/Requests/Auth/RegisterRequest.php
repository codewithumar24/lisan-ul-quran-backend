<?php

namespace Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\User\DataTransfer\Requests\Auth\RegisterDTO;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cnic' => ['nullable', 'string', 'unique:users,cnic'],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
            'gender' => ['nullable', Rule::in(['male', 'female'])],
            'country' => ['nullable', 'string', 'max:100'],
            'city' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'student_type' => ['nullable', Rule::in(['military', 'civilian'])],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    public function getDTO(): RegisterDTO
    {
        return RegisterDTO::create(
            $this->input('first_name'),
            $this->input('last_name'),
            $this->input('email'),
            $this->input('password'),
            $this->input('password_confirmation'),
            $this->input('cnic'),
            $this->input('phone'),
            $this->input('date_of_birth'),
            $this->input('gender'),
            $this->input('country'),
            $this->input('city'),
            $this->input('address'),
            $this->input('student_type')
        );
    }
}
