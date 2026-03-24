<?php

namespace Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\DataTransfer\Requests\Auth\LoginDTO;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required.',
            'password.required' => 'Password is required.',
        ];
    }

    public function getDTO(): LoginDTO
    {
        return LoginDTO::create(
            $this->input('email'),
            $this->input('password'),
            $this->boolean('remember')
        );
    }
}
