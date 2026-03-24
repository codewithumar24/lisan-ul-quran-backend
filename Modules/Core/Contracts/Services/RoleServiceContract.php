<?php

namespace Modules\Core\Contracts\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\DataTransfer\Requests\RoleDTO;
use Modules\Core\Entities\Role;

interface RoleServiceContract
{
    public function create(RoleDTO $dto): Role;
    public function update(Role $role, RoleDTO $dto): Role;
    public function delete(Role $role): ?bool;
    public function findById(int $id): ?Role;
    public function findByUuid(string $uuid): ?Role;
    public function getAll(int|null $perPage = null): LengthAwarePaginator|Collection;
}
