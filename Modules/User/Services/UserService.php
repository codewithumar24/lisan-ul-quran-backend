<?php

namespace Modules\User\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\Core\Contracts\Repositories\RoleRepositoryContract;
use Modules\User\Contracts\Repositories\UserRepositoryContract;
use Modules\User\Contracts\Services\UserServiceContract;
use Modules\User\DataTransfer\Requests\Auth\ChangePasswordDTO;
use Modules\User\DataTransfer\Requests\Auth\ForgotPasswordDTO;
use Modules\User\DataTransfer\Requests\Auth\LoginDTO;
use Modules\User\DataTransfer\Requests\Auth\RegisterDTO;
use Modules\User\DataTransfer\Requests\Auth\ResetPasswordDTO;
use Modules\User\DataTransfer\Requests\UserDTO;
use Modules\User\Entities\User;
use Modules\User\Mail\AccountCreatedMail;
use Modules\User\Mail\PasswordResetMail;
use Modules\User\Mail\WelcomeMail;

readonly class UserService implements UserServiceContract
{
    public function __construct(
        private UserRepositoryContract $userRepository,
        private RoleRepositoryContract $roleRepository
    ) {}

    // Authentication Methods
    public function register(RegisterDTO $dto): User
    {
        // Get student role
        $studentRole = $this->roleRepository->findByName('Student');

        $user = $this->userRepository->create(
            $dto->getFirstName(),
            $dto->getLastName(),
            $dto->getEmail(),
            $dto->getPassword(),
            $studentRole->id,
            $dto->getCnic(),
            $dto->getPhone(),
            $dto->getDateOfBirth(),
            $dto->getGender(),
            $dto->getCountry(),
            $dto->getCity(),
            $dto->getAddress(),
            $dto->getStudentType()
        );

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeMail($user));

        return $user;
    }

    public function login(LoginDTO $dto): array
    {
        $user = $this->userRepository->findByEmail($dto->getEmail());

        if (!$user || !Hash::check($dto->getPassword(), $user->password)) {
            throw new \Exception('Invalid credentials', 401);
        }

        if (!$user->is_active) {
            throw new \Exception('Your account is inactive. Please contact admin.', 403);
        }

        // Create Sanctum token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function forgotPassword(ForgotPasswordDTO $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->getEmail());

        if (!$user) {
            throw new \Exception('User not found with this email.', 404);
        }

        // Generate reset token
        $token = Password::createToken($user);

        // Send reset email
        Mail::to($user->email)->send(new PasswordResetMail($user, $token));
    }

    public function resetPassword(ResetPasswordDTO $dto): void
    {
        $user = $this->userRepository->findByEmail($dto->getEmail());

        if (!$user) {
            throw new \Exception('User not found.', 404);
        }

        // Verify token
        if (!Password::tokenExists($user, $dto->getToken())) {
            throw new \Exception('Invalid or expired reset token.', 400);
        }

        // Update password
        $this->userRepository->updatePassword($user, $dto->getPassword());

        // Delete reset token
        Password::deleteToken($user);
    }

    public function changePassword(User $user, ChangePasswordDTO $dto): void
    {
        if (!Hash::check($dto->getCurrentPassword(), $user->password)) {
            throw new \Exception('Current password is incorrect.', 400);
        }

        $this->userRepository->updatePassword($user, $dto->getNewPassword());
    }

    public function verifyEmail(string $token): void
    {
        // Implement email verification logic
        // You can use Laravel's built-in verification or custom implementation
    }

    // Google Login Methods
    public function getGoogleAuthUrl(): string
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();
    }

    public function handleGoogleCallback(string $code): array
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Check if user exists
            $user = $this->userRepository->findByGoogleId($googleUser->getId());

            if (!$user) {
                // Check if user exists with same email
                $user = $this->userRepository->findByEmail($googleUser->getEmail());

                if ($user) {
                    // Update google id
                    $this->userRepository->update($user,
                        googleId: $googleUser->getId(),
                        googleAvatar: $googleUser->getAvatar(),
                        googleToken: $googleUser->token,
                        googleRefreshToken: $googleUser->refreshToken
                    );
                } else {
                    // Create new user with google data
                    $studentRole = $this->roleRepository->findByName('Student');

                    $nameParts = explode(' ', $googleUser->getName(), 2);
                    $firstName = $nameParts[0];
                    $lastName = $nameParts[1] ?? '';

                    $user = $this->userRepository->create(
                        $firstName,
                        $lastName,
                        $googleUser->getEmail(),
                        Str::random(16), // Random password
                        $studentRole->id,
                        null, null, null, null, null, null, null, null,
                        true
                    );

                    // Update with google info
                    $this->userRepository->update($user,
                        googleId: $googleUser->getId(),
                        googleAvatar: $googleUser->getAvatar(),
                        googleToken: $googleUser->token,
                        googleRefreshToken: $googleUser->refreshToken
                    );

                    // Send welcome email
                    Mail::to($user->email)->send(new WelcomeMail($user));
                }
            }

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];

        } catch (\Exception $e) {
            throw new \Exception('Google authentication failed: ' . $e->getMessage(), 400);
        }
    }

    // User Management Methods
    public function create(UserDTO $dto): User
    {
        $user = $this->userRepository->create(
            $dto->getFirstName(),
            $dto->getLastName(),
            $dto->getEmail(),
            $dto->getPassword(),
            $dto->getRoleId(),
            $dto->getCnic(),
            $dto->getPhone(),
            $dto->getDateOfBirth(),
            $dto->getGender(),
            $dto->getCountry(),
            $dto->getCity(),
            $dto->getAddress(),
            $dto->getStudentType(),
            $dto->getIsActive()
        );

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeMail($user));

        return $user;
    }

    public function update(User $user, UserDTO $dto): User
    {
        return $this->userRepository->update(
            $user,
            $dto->getFirstName(),
            $dto->getLastName(),
            $dto->getEmail(),
            $dto->getPassword(),
            $dto->getRoleId(),
            $dto->getCnic(),
            $dto->getPhone(),
            $dto->getDateOfBirth(),
            $dto->getGender(),
            $dto->getCountry(),
            $dto->getCity(),
            $dto->getAddress(),
            $dto->getStudentType(),
            $dto->getIsActive()
        );
    }

    public function delete(User $user): ?bool
    {
        return $this->userRepository->delete($user);
    }

    public function findById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?User
    {
        return $this->userRepository->findByUuid($uuid);
    }

    public function getAll(
        int|null $perPage = null,
        int|null $roleId = null,
        bool|null $isActive = null,
        string|null $search = null
    ): LengthAwarePaginator|Collection {
        return $this->userRepository->getAll(
            $perPage,
            $roleId,
            $isActive,
            $search,
            ['role']
        );
    }

    // Admin Functions
    public function adminCreateUser(UserDTO $dto): User
    {
        // Generate password from CNIC (last 6 digits)
        $password = $this->userRepository->generatePasswordFromCnic($dto->getCnic());

        // Override the provided password
        $dto = UserDTO::create(
            $dto->getFirstName(),
            $dto->getLastName(),
            $dto->getEmail(),
            $password, // Use generated password
            $dto->getRoleId(),
            $dto->getCnic(),
            $dto->getPhone(),
            $dto->getDateOfBirth(),
            $dto->getGender(),
            $dto->getCountry(),
            $dto->getCity(),
            $dto->getAddress(),
            $dto->getStudentType(),
            $dto->getIsActive()
        );

        $user = $this->create($dto);

        // Send email with credentials
        Mail::to($user->email)->send(new AccountCreatedMail($user, $password));

        return $user;
    }

    public function adminChangePassword(User $user, string $newPassword): void
    {
        $this->userRepository->updatePassword($user, $newPassword);

        // Optionally send email notification
        Mail::to($user->email)->send(new PasswordChangedMail($user));
    }
}
