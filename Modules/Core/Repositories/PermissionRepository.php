<?php

namespace Modules\Core\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Core\Contracts\Repositories\PermissionRepositoryContract;
use Modules\Core\Entities\Permission;

readonly class PermissionRepository implements PermissionRepositoryContract
{
    public function __construct(
        private Permission $model
    ) {}

    public function create(string $name, string $group = null, string $description = null): Permission
    {
        return $this->model->newQuery()->create([
            'name' => $name,
            'group' => $group,
            'description' => $description,
        ]);
    }

    public function update(Permission $permission, ?string $name = null, ?string $group = null, ?string $description = null): Permission
    {
        if (!is_null($name) && $permission->name !== $name) {
            $permission->name = $name;
        }
        if (!is_null($group) && $permission->group !== $group) {
            $permission->group = $group;
        }
        if (!is_null($description) && $permission->description !== $description) {
            $permission->description = $description;
        }
        $permission->save();

        return $permission;
    }

    public function delete(Permission $permission): bool
    {
        return $permission->delete();
    }

    public function findById(int $id): ?Permission
    {
        return $this->model->newQuery()->find($id);
    }

    public function findByUuid(string $uuid): ?Permission
    {
        return $this->model->newQuery()->where('uuid', $uuid)->first();
    }

    public function findByName(string $name): ?Permission
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }

    public function getAll(int|null $perPage = null, string|null $group = null): LengthAwarePaginator|Collection
    {
        $query = $this->model->newQuery();

        if ($group) {
            $query->where('group', $group);
        }

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getGroups(): Collection
    {
        return $this->model->newQuery()
            ->select('group')
            ->distinct()
            ->whereNotNull('group')
            ->pluck('group');
    }
}
