<?php

namespace Modules\User\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Entities\User;

readonly class UserRepository implements UserRepositoryContract
{
    public function __construct(
        private User $model
    ) {}

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
    ): User {
        return $this->model->newQuery()->create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $roleId,
            'cnic' => $cnic,
            'phone' => $phone,
            'date_of_birth' => $dateOfBirth,
            'gender' => $gender,
            'country' => $country,
            'city' => $city,
            'address' => $address,
            'student_type' => $studentType,
            'is_active' => $isActive,
        ]);
    }

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
    ): User {
        if (!is_null($firstName) && $user->first_name !== $firstName) {
            $user->first_name = $firstName;
        }
        if (!is_null($lastName) && $user->last_name !== $lastName) {
            $user->last_name = $lastName;
        }
        if (!is_null($email) && $user->email !== $email) {
            $user->email = $email;
        }
        if (!is_null($password)) {
            $user->password = Hash::make($password);
        }
        if (!is_null($roleId) && $user->role_id !== $roleId) {
            $user->role_id = $roleId;
        }
        if (!is_null($cnic) && $user->cnic !== $cnic) {
            $user->cnic = $cnic;
        }
        if (!is_null($phone) && $user->phone !== $phone) {
            $user->phone = $phone;
        }
        if (!is_null($dateOfBirth) && $user->date_of_birth?->format('Y-m-d') !== $dateOfBirth) {
            $user->date_of_birth = $dateOfBirth;
        }
        if (!is_null($gender) && $user->gender !== $gender) {
            $user->gender = $gender;
        }
        if (!is_null($country) && $user->country !== $country) {
            $user->country = $country;
        }
        if (!is_null($city) && $user->city !== $city) {
            $user->city = $city;
        }
        if (!is_null($address) && $user->address !== $address) {
            $user->address = $address;
        }
        if (!is_null($studentType) && $user->student_type !== $studentType) {
            $user->student_type = $studentType;
        }
        if (!is_null($isActive) && $user->is_active !== $isActive) {
            $user->is_active = $isActive;
        }
        $user->save();

        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function findById(int $id): ?User
    {
        return $this->model->newQuery()->with('role')->find($id);
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->model->newQuery()->with('role')->where('uuid', $uuid)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->with('role')->where('email', $email)->first();
    }

    public function findByCnic(string $cnic): ?User
    {
        return $this->model->newQuery()->with('role')->where('cnic', $cnic)->first();
    }

    public function findByGoogleId(string $googleId): ?User
    {
        return $this->model->newQuery()->with('role')->where('google_id', $googleId)->first();
    }

    public function getAll(
        int|null $perPage = null,
        int|null $roleId = null,
        bool|null $isActive = null,
        string|null $search = null,
        array $with = []
    ): LengthAwarePaginator|Collection {
        $query = $this->model->newQuery()->with($with);

        if ($roleId) {
            $query->where('role_id', $roleId);
        }

        if (!is_null($isActive)) {
            $query->where('is_active', $isActive);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('cnic', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $query->latest();

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function updatePassword(User $user, string $password): User
    {
        $user->password = Hash::make($password);
        $user->save();
        return $user;
    }

    public function generatePasswordFromCnic(string $cnic): string
    {
        // Get last 6 digits of CNIC (remove dashes if present)
        $cleanCnic = str_replace('-', '', $cnic);
        return substr($cleanCnic, -6);
    }
}
