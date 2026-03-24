<?php

namespace Modules\User\DataTransfer\Requests;

use Modules\Core\DataTransfer\DTO;

final class UserDTO implements DTO
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly ?string $password,
        private readonly int $roleId,
        private readonly ?string $cnic,
        private readonly ?string $phone,
        private readonly ?string $dateOfBirth,
        private readonly ?string $gender,
        private readonly ?string $country,
        private readonly ?string $city,
        private readonly ?string $address,
        private readonly ?string $studentType,
        private readonly bool $isActive = true
    ) {}

    public static function create(
        string $firstName,
        string $lastName,
        string $email,
        ?string $password = null,
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
    ): self {
        return new self(
            $firstName,
            $lastName,
            $email,
            $password,
            $roleId,
            $cnic,
            $phone,
            $dateOfBirth,
            $gender,
            $country,
            $city,
            $address,
            $studentType,
            $isActive
        );
    }

    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): ?string { return $this->password; }
    public function getRoleId(): int { return $this->roleId; }
    public function getCnic(): ?string { return $this->cnic; }
    public function getPhone(): ?string { return $this->phone; }
    public function getDateOfBirth(): ?string { return $this->dateOfBirth; }
    public function getGender(): ?string { return $this->gender; }
    public function getCountry(): ?string { return $this->country; }
    public function getCity(): ?string { return $this->city; }
    public function getAddress(): ?string { return $this->address; }
    public function getStudentType(): ?string { return $this->studentType; }
    public function getIsActive(): bool { return $this->isActive; }
}
