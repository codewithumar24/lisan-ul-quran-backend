<?php

namespace Modules\Core\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\DataTransfer\Requests\PermissionDTO;
use Modules\Core\Entities\Permission;

interface PermissionServiceContract
{
    public function create(PermissionDTO $dto): Permission;
    public function update(Permission $permission, PermissionDTO $dto): Permission;
    public function delete(Permission $permission): ?bool;
    public function findById(int $id): ?Permission;
    public function findByUuid(string $uuid): ?Permission;
    public function getAll(int|null $perPage = null, string|null $group = null): LengthAwarePaginator|Collection;
    public function getGroups(): Collection;
}
