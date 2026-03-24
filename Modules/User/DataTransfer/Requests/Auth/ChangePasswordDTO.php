<?php

namespace Modules\User\DataTransfer\Requests\Auth;

use Modules\Core\DataTransfer\DTO;

final class ChangePasswordDTO implements DTO
{
    public function __construct(
        private readonly string $currentPassword,
        private readonly string $newPassword,
        private readonly string $newPasswordConfirmation
    ) {}

    public static function create(
        string $currentPassword,
        string $newPassword,
        string $newPasswordConfirmation
    ): self {
        return new self($currentPassword, $newPassword, $newPasswordConfirmation);
    }

    public function getCurrentPassword(): string { return $this->currentPassword; }
    public function getNewPassword(): string { return $this->newPassword; }
    public function getNewPasswordConfirmation(): string { return $this->newPasswordConfirmation; }
}
