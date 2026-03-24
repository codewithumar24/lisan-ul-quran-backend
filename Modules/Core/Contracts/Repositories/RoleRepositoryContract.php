<?php

namespace Modules\Core\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Entities\Role;

interface RoleRepositoryContract
{
    public function create(string $name,  array $permissions = []): Role;
    public function update(Role $role, ?string $name = null, ?array $permissions = []): Role;
    public function delete(Role $role): bool;
    public function findById(int $id): ?Role;
    public function findByUuid(string $uuid): ?Role;
    public function findByName(string $name): ?Role;
    public function getAll(int|null $perPage = null, array $with = []): LengthAwarePaginator|Collection;
    public function assignPermissions(Role $role, array $permissionIds): Role;
    public function syncPermissions(Role $role, array $permissionIds): Role;
}
