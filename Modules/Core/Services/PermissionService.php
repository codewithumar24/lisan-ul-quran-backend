<?php

namespace Modules\Core\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\Core\Contracts\Services\PermissionServiceContract;
use Modules\Core\DataTransfer\Requests\PermissionDTO;
use Modules\Core\Entities\Permission;

readonly class PermissionService implements PermissionServiceContract
{
    public function __construct(
        private PermissionRepositoryContract $permissionRepository
    ) {}

    public function create(PermissionDTO $dto): Permission
    {
        return $this->permissionRepository->create(
            $dto->getName(),
            $dto->getGroup(),
            $dto->getDescription()
        );
    }

    public function update(Permission $permission, PermissionDTO $dto): Permission
    {
        return $this->permissionRepository->update(
            $permission,
            $dto->getName(),
            $dto->getGroup(),
            $dto->getDescription()
        );
    }

    public function delete(Permission $permission): ?bool
    {
        return $this->permissionRepository->delete($permission);
    }

    public function findById(int $id): ?Permission
    {
        return $this->permissionRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?Permission
    {
        return $this->permissionRepository->findByUuid($uuid);
    }

    public function getAll(int|null $perPage = null, string|null $group = null): LengthAwarePaginator|Collection
    {
        return $this->permissionRepository->getAll($perPage, $group);
    }

    public function getGroups(): Collection
    {
        return $this->permissionRepository->getGroups();
    }
}
