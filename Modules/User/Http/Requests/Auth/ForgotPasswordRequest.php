<?php

namespace Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\DataTransfer\Requests\Auth\ForgotPasswordDTO;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required.',
            'email.exists' => 'We could not find a user with that email address.',
        ];
    }

    public function getDTO(): ForgotPasswordDTO
    {
        return ForgotPasswordDTO::create($this->input('email'));
    }
}
