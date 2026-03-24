<?php

namespace Modules\Core\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Contracts\Repositories\RoleRepositoryContract;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\Permission;

readonly class RoleRepository implements RoleRepositoryContract
{
    public function __construct(
        private Role $model
    ) {}

    public function create(string $name, array $permissions = []): Role
    {
        $role = $this->model->newQuery()->create([
            'name' => $name,
        ]);

        if (!empty($permissions)) {
            $role->permissions()->sync($permissions);
        }

        return $role;
    }

    public function update(Role $role, ?string $name = null, ?array $permissions = []): Role
    {
        if (!is_null($name) && $role->name !== $name) {
            $role->name = $name;
        }
        if (!is_null($description) && $role->description !== $description) {
            $role->description = $description;
        }
        $role->save();

        if (!is_null($permissions)) {
            $role->permissions()->sync($permissions);
        }

        return $role;
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function findById(int $id): ?Role
    {
        return $this->model->newQuery()->with('permissions')->find($id);
    }

    public function findByUuid(string $uuid): ?Role
    {
        return $this->model->newQuery()->with('permissions')->where('uuid', $uuid)->first();
    }

    public function findByName(string $name): ?Role
    {
        return $this->model->newQuery()->with('permissions')->where('name', $name)->first();
    }

    public function getAll(int|null $perPage = null, array $with = []): LengthAwarePaginator|Collection
    {
        $query = $this->model->newQuery()->with($with);

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function assignPermissions(Role $role, array $permissionIds): Role
    {
        $role->permissions()->attach($permissionIds);
        return $role;
    }

    public function syncPermissions(Role $role, array $permissionIds): Role
    {
        $role->permissions()->sync($permissionIds);
        return $role;
    }
}
