<?php

namespace Modules\User\DataTransfer\Requests\Auth;

use Modules\Core\DataTransfer\DTO;

final class ResetPasswordDTO implements DTO
{
    public function __construct(
        private readonly string $email,
        private readonly string $token,
        private readonly string $password,
        private readonly string $passwordConfirmation
    ) {}

    public static function create(
        string $email,
        string $token,
        string $password,
        string $passwordConfirmation
    ): self {
        return new self($email, $token, $password, $passwordConfirmation);
    }

    public function getEmail(): string { return $this->email; }
    public function getToken(): string { return $this->token; }
    public function getPassword(): string { return $this->password; }
    public function getPasswordConfirmation(): string { return $this->passwordConfirmation; }
}
