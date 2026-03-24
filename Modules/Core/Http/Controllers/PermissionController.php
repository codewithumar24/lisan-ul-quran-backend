<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Core\Contracts\Services\PermissionServiceContract;
use Modules\Core\Http\Requests\Permission\PermissionRequest;
use Modules\Core\Transformers\PermissionTransformer;

class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionServiceContract $permissionService
    ) {}

    public function index(): JsonResponse
    {
        $permissions = $this->permissionService->getAll(
            request()->get('per_page'),
            request()->get('group')
        );

        return apiResponse()->pagination($permissions)->success(PermissionTransformer::collection($permissions));
    }

    public function groups(): JsonResponse
    {
        $groups = $this->permissionService->getGroups();
        return apiResponse()->success($groups);
    }

    public function store(PermissionRequest $request): JsonResponse
    {
        $permission = $this->permissionService->create($request->getDTO());
        return apiResponse()->success(new PermissionTransformer($permission));
    }

    public function show(string $uuid): JsonResponse
    {
        $permission = $this->permissionService->findByUuid($uuid);

        if (!$permission) {
            return apiResponse()->error('Permission not found.', 404);
        }

        return apiResponse()->success(new PermissionTransformer($permission));
    }

    public function update(string $uuid, PermissionRequest $request): JsonResponse
    {
        $permission = $this->permissionService->findByUuid($uuid);

        if (!$permission) {
            return apiResponse()->error('Permission not found.', 404);
        }

        $updatedPermission = $this->permissionService->update($permission, $request->getDTO());
        return apiResponse()->success(new PermissionTransformer($updatedPermission));
    }

    public function destroy(string $uuid): JsonResponse
    {
        $permission = $this->permissionService->findByUuid($uuid);

        if (!$permission) {
            return apiResponse()->error('Permission not found.', 404);
        }

        $this->permissionService->delete($permission);
        return apiResponse()->success('Permission deleted successfully.');
    }
}
