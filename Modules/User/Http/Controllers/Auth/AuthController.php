<?php

namespace Modules\User\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Contracts\Services\UserServiceContract;
use Modules\User\Http\Requests\Auth\ChangePasswordRequest;
use Modules\User\Http\Requests\Auth\ForgotPasswordRequest;
use Modules\User\Http\Requests\Auth\LoginRequest;
use Modules\User\Http\Requests\Auth\RegisterRequest;
use Modules\User\Http\Requests\Auth\ResetPasswordRequest;
use Modules\User\Transformers\Auth\LoginResponseTransformer;
use Modules\User\Transformers\UserTransformer;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->getDTO());
        return apiResponse()->success(new UserTransformer($user), 'Registration successful. Please check your email for verification.');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->login($request->getDTO());
            return apiResponse()->success(new LoginResponseTransformer($result), 'Login successful.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 401);
        }
    }

    public function logout(): JsonResponse
    {
        $this->userService->logout(auth()->user());
        return apiResponse()->success(null, 'Logged out successfully.');
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $this->userService->forgotPassword($request->getDTO());
            return apiResponse()->success(null, 'Password reset link sent to your email.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->userService->resetPassword($request->getDTO());
            return apiResponse()->success(null, 'Password reset successful.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $this->userService->changePassword(auth()->user(), $request->getDTO());
            return apiResponse()->success(null, 'Password changed successfully.');
        } catch (\Exception $e) {
            return apiResponse()->error($e->getMessage(), $e->getCode() ?: 400);
        }
    }

    public function me(): JsonResponse
    {
        return apiResponse()->success(new UserTransformer(auth()->user()->load('role')));
    }
}
