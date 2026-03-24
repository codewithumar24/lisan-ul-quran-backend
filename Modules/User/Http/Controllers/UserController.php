<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\User\Contracts\Services\UserServiceContract;
use Modules\User\Http\Requests\User\UserRequest;
use Modules\User\Transformers\UserTransformer;

class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceContract $userService
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->getAll(
            request()->get('per_page'),
            request()->get('role_id'),
            request()->get('is_active') !== null ? filter_var(request()->get('is_active'), FILTER_VALIDATE_BOOLEAN) : null,
            request()->get('search')
        );

        return apiResponse()->pagination($users)->success(UserTransformer::collection($users));
    }

    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userService->create($request->getDTO());
        return apiResponse()->success(new UserTransformer($user->load('role')), 'User created successfully.');
    }

    public function show(string $uuid): JsonResponse
    {
        $user = $this->userService->findByUuid($uuid);

        if (!$user) {
            return apiResponse()->error('User not found.', 404);
        }

        return apiResponse()->success(new UserTransformer($user->load('role')));
    }

    public function update(string $uuid, UserRequest $request): JsonResponse
    {
        $user = $this->userService->findByUuid($uuid);

        if (!$user) {
            return apiResponse()->error('User not found.', 404);
        }

        $updatedUser = $this->userService->update($user, $request->getDTO());
        return apiResponse()->success(new UserTransformer($updatedUser->load('role')), 'User updated successfully.');
    }

    public function destroy(string $uuid): JsonResponse
    {
        $user = $this->userService->findByUuid($uuid);

        if (!$user) {
            return apiResponse()->error('User not found.', 404);
        }

        $this->userService->delete($user);
        return apiResponse()->success(null, 'User deleted successfully.');
    }

    public function adminCreate(UserRequest $request): JsonResponse
    {
        $user = $this->userService->adminCreateUser($request->getDTO());
        return apiResponse()->success(new UserTransformer($user->load('role')), 'User created successfully. Password has been sent to email.');
    }
}
