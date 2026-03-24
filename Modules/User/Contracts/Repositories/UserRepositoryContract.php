<?php

namespace Modules\User\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\User\Entities\User;

interface UserRepositoryContract
{
    public function create(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        int $roleId,
        ?string $cnic = null,
        ?string $phone = null,
        ?string $dateOfBirth = null,
        ?string $gender = null,
        ?string $country = null,
        ?string $city = null,
        ?string $address = null,
        ?string $studentType = null,
        bool $isActive = true
    ): User;

    public function update(
        User $user,
        ?string $firstName = null,
        ?string $lastName = null,
        ?string $email = null,
        ?string $password = null,
        ?int $roleId = null,
        ?string $cnic = null,
        ?string $phone = null,
        ?string $dateOfBirth = null,
        ?string $gender = null,
        ?string $country = null,
        ?string $city = null,
        ?string $address = null,
        ?string $studentType = null,
        ?bool $isActive = null
    ): User;

    public function delete(User $user): bool;
    public function findById(int $id): ?User;
    public function findByUuid(string $uuid): ?User;
    public function findByEmail(string $email): ?User;
    public function findByCnic(string $cnic): ?User;
    public function findByGoogleId(string $googleId): ?User;
    public function getAll(
        int|null $perPage = null,
        int|null $roleId = null,
        bool|null $isActive = null,
        string|null $search = null,
        array $with = []
    ): LengthAwarePaginator|Collection;
    public function updatePassword(User $user, string $password): User;
    public function generatePasswordFromCnic(string $cnic): string;
}
