<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Core\Contracts\Services\RoleServiceContract;
use Modules\Core\Http\Requests\Role\RoleRequest;
use Modules\Core\Transformers\RoleTransformer;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleServiceContract $roleService
    ) {}

    public function index(): JsonResponse
    {
        $roles = $this->roleService->getAll(request()->get('per_page'));
        return apiResponse()->pagination($roles)->success(RoleTransformer::collection($roles));
    }

    public function store(RoleRequest $request): JsonResponse
    {
        $role = $this->roleService->create($request->getDTO());
        return apiResponse()->success(new RoleTransformer($role->load('permissions')));
    }

    public function show(string $uuid): JsonResponse
    {
        $role = $this->roleService->findByUuid($uuid);

        if (!$role) {
            return apiResponse()->error('Role not found.', 404);
        }

        return apiResponse()->success(new RoleTransformer($role->load('permissions')));
    }

    public function update(string $uuid, RoleRequest $request): JsonResponse
    {
        $role = $this->roleService->findByUuid($uuid);

        if (!$role) {
            return apiResponse()->error('Role not found.', 404);
        }

        $updatedRole = $this->roleService->update($role, $request->getDTO());
        return apiResponse()->success(new RoleTransformer($updatedRole->load('permissions')));
    }

    public function destroy(string $uuid): JsonResponse
    {
        $role = $this->roleService->findByUuid($uuid);

        if (!$role) {
            return apiResponse()->error('Role not found.', 404);
        }

        $this->roleService->delete($role);
        return apiResponse()->success('Role deleted successfully.');
    }
}
