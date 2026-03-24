<?php

namespace Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\DataTransfer\Requests\Auth\ResetPasswordDTO;

class ResetPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }

    public function getDTO(): ResetPasswordDTO
    {
        return ResetPasswordDTO::create(
            $this->input('email'),
            $this->input('token'),
            $this->input('password'),
            $this->input('password_confirmation')
        );
    }
}
