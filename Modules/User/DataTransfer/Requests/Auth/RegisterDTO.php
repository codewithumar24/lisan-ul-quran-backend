<?php

namespace Modules\User\DataTransfer\Requests\Auth;

use Modules\Core\DataTransfer\DTO;

final class RegisterDTO implements DTO
{
    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly string $password,
        private readonly string $passwordConfirmation,
        private readonly ?string $cnic,
        private readonly ?string $phone,
        private readonly ?string $dateOfBirth,
        private readonly ?string $gender,
        private readonly ?string $country,
        private readonly ?string $city,
        private readonly ?string $address,
        private readonly ?string $studentType
    ) {}

    public static function create(
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        string $passwordConfirmation,
        ?string $cnic = null,
        ?string $phone = null,
        ?string $dateOfBirth = null,
        ?string $gender = null,
        ?string $country = null,
        ?string $city = null,
        ?string $address = null,
        ?string $studentType = null
    ): self {
        return new self(
            $firstName,
            $lastName,
            $email,
            $password,
            $passwordConfirmation,
            $cnic,
            $phone,
            $dateOfBirth,
            $gender,
            $country,
            $city,
            $address,
            $studentType
        );
    }

    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getPasswordConfirmation(): string { return $this->passwordConfirmation; }
    public function getCnic(): ?string { return $this->cnic; }
    public function getPhone(): ?string { return $this->phone; }
    public function getDateOfBirth(): ?string { return $this->dateOfBirth; }
    public function getGender(): ?string { return $this->gender; }
    public function getCountry(): ?string { return $this->country; }
    public function getCity(): ?string { return $this->city; }
    public function getAddress(): ?string { return $this->address; }
    public function getStudentType(): ?string { return $this->studentType; }
}
