<?php

namespace Modules\Core\Contracts\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Entities\Permission;

interface PermissionRepositoryContract
{
    public function create(string $name, string $group = null, string $description = null): Permission;
    public function update(Permission $permission, ?string $name = null, ?string $group = null, ?string $description = null): Permission;
    public function delete(Permission $permission): bool;
    public function findById(int $id): ?Permission;
    public function findByUuid(string $uuid): ?Permission;
    public function findByName(string $name): ?Permission;
    public function getAll(int|null $perPage = null, string|null $group = null): LengthAwarePaginator|Collection;
    public function getGroups(): Collection;
}
