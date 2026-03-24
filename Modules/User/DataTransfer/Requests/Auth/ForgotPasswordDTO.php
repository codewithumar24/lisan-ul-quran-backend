<?php

namespace Modules\User\DataTransfer\Requests\Auth;

use Modules\Core\DataTransfer\DTO;

final class ForgotPasswordDTO implements DTO
{
    public function __construct(
        private readonly string $email
    ) {}

    public static function create(string $email): self
    {
        return new self($email);
    }

    public function getEmail(): string { return $this->email; }
}
