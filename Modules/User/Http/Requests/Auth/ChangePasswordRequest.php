<?php

namespace Modules\User\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\DataTransfer\Requests\Auth\ChangePasswordDTO;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Current password is required.',
            'current_password.current_password' => 'Current password is incorrect.',
            'new_password.required' => 'New password is required.',
            'new_password.confirmed' => 'New password confirmation does not match.',
        ];
    }

    public function getDTO(): ChangePasswordDTO
    {
        return ChangePasswordDTO::create(
            $this->input('current_password'),
            $this->input('new_password'),
            $this->input('new_password_confirmation')
        );
    }
}
