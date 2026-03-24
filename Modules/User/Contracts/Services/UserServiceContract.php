<?php

namespace Modules\User\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\User\DataTransfer\Requests\Auth\ChangePasswordDTO;
use Modules\User\DataTransfer\Requests\Auth\ForgotPasswordDTO;
use Modules\User\DataTransfer\Requests\Auth\LoginDTO;
use Modules\User\DataTransfer\Requests\Auth\RegisterDTO;
use Modules\User\DataTransfer\Requests\Auth\ResetPasswordDTO;
use Modules\User\DataTransfer\Requests\UserDTO;
use Modules\User\Entities\User;

interface UserServiceContract
{
    public function register(RegisterDTO $dto): User;
    public function login(LoginDTO $dto): array;
    public function logout(User $user): void;
    public function forgotPassword(ForgotPasswordDTO $dto): void;
    public function resetPassword(ResetPasswordDTO $dto): void;
    public function changePassword(User $user, ChangePasswordDTO $dto): void;
    public function verifyEmail(string $token): void;

    // Google Login
    public function handleGoogleCallback(string $code): array;
    public function getGoogleAuthUrl(): string;

    // User Management
    public function create(UserDTO $dto): User;
    public function update(User $user, UserDTO $dto): User;
    public function delete(User $user): ?bool;
    public function findById(int $id): ?User;
    public function findByUuid(string $uuid): ?User;
    public function getAll(
        int|null $perPage = null,
        int|null $roleId = null,
        bool|null $isActive = null,
        string|null $search = null
    ): LengthAwarePaginator|Collection;

    // Admin functions
    public function adminCreateUser(UserDTO $dto): User;
    public function adminChangePassword(User $user, string $newPassword): void;
}
