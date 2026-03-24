<?php

namespace Modules\Core\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Contracts\Repositories\RoleRepositoryContract;
use Modules\Core\Contracts\Services\RoleServiceContract;
use Modules\Core\DataTransfer\Requests\RoleDTO;
use Modules\Core\Entities\Role;

readonly class RoleService implements RoleServiceContract
{
    public function __construct(
        private RoleRepositoryContract $roleRepository
    ) {}

    public function create(RoleDTO $dto): Role
    {
        return $this->roleRepository->create(
            $dto->getName(),
            $dto->getDescription(),
            $dto->getPermissions()
        );
    }

    public function update(Role $role, RoleDTO $dto): Role
    {
        return $this->roleRepository->update(
            $role,
            $dto->getName(),
            $dto->getDescription(),
            $dto->getPermissions()
        );
    }

    public function delete(Role $role): ?bool
    {
        return $this->roleRepository->delete($role);
    }

    public function findById(int $id): ?Role
    {
        return $this->roleRepository->findById($id);
    }

    public function findByUuid(string $uuid): ?Role
    {
        return $this->roleRepository->findByUuid($uuid);
    }

    public function getAll(int|null $perPage = null): LengthAwarePaginator|Collection
    {
        return $this->roleRepository->getAll($perPage, ['permissions']);
    }
}
