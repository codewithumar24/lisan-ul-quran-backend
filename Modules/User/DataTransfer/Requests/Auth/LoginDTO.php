<?php

namespace Modules\User\DataTransfer\Requests\Auth;

use Modules\Core\DataTransfer\DTO;

final class LoginDTO implements DTO
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
        private readonly bool $remember = false
    ) {}

    public static function create(
        string $email,
        string $password,
        bool $remember = false
    ): self {
        return new self($email, $password, $remember);
    }

    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRemember(): bool { return $this->remember; }
}
