<?php

namespace Modules\Core\Console;

use Illuminate\Console\Command;
use Modules\Core\Entities\Role;
use Modules\Core\Entities\Permission;

class SeedRolesAndPermissions extends Command
{
    protected $signature = 'core:seed-roles-permissions';
    protected $description = 'Seed default roles and permissions';

    public function handle(): void
    {
        $this->info('Seeding roles and permissions...');

        $permissions = [
            // User permissions
            ['name' => 'View Users', 'group' => 'User'],
            ['name' => 'Create Users', 'group' => 'User'],
            ['name' => 'Update Users', 'group' => 'User'],
            ['name' => 'Delete Users', 'group' => 'User'],

            ['name' => 'View Roles', 'group' => 'Role'],
            ['name' => 'Create Roles', 'group' => 'Role'],
            ['name' => 'Update Roles', 'group' => 'Role'],
            ['name' => 'Delete Roles', 'group' => 'Role'],

            ['name' => 'View Permissions', 'group' => 'Permission'],
            ['name' => 'Create Permissions', 'group' => 'Permission'],
            ['name' => 'Update Permissions', 'group' => 'Permission'],
            ['name' => 'Delete Permissions', 'group' => 'Permission'],

            ['name' => 'Get Classes', 'group' => 'Class'],
            ['name' => 'Create Class', 'group' => 'Class'],
            ['name' => 'Update Class', 'group' => 'Class'],
            ['name' => 'Delete Class', 'group' => 'Class'],
            ['name' => 'View Class', 'group' => 'Class'],


            ['name' => 'View Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'Create Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'Update Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'Delete Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'View Makhraj Categories', 'group' => 'Makhraj Categories'],
            ['name' => 'Create Makhraj Categories', 'group' => 'Makhraj Categories'],
            ['name' => 'Update Makhraj Categories', 'group' => 'Makhraj Categories'],
            ['name' => 'Delete Makhraj Categories', 'group' => 'Makhraj Categories'],

            ['name' => 'View Tajweed Rules', 'group' => 'Tajweed Rules'],
            ['name' => 'Create Tajweed Rules', 'group' => 'Tajweed Rules'],
            ['name' => 'Update Tajweed Rules', 'group' => 'Tajweed Rules'],
            ['name' => 'Delete Tajweed Rules', 'group' => 'Tajweed Rules']
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                [
                    'slug' => str($perm['name'])->slug(),
                    'group' => $perm['group'],
                ]
            );
        }

        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['slug' => 'admin', 'description' => 'Administrator with full access']
        );

        $teacherRole = Role::firstOrCreate(
            ['name' => 'Teacher'],
            ['slug' => 'teacher', 'description' => 'Teacher role with limited access']
        );

        $studentRole = Role::firstOrCreate(
            ['name' => 'Student'],
            ['slug' => 'student', 'description' => 'Student role with basic access']
        );

        $adminRole->permissions()->sync(Permission::all());

        $teacherPermissions = Permission::whereIn('group', ['Class'])->pluck('id');
        $teacherRole->permissions()->sync($teacherPermissions);

        $this->info('Roles and permissions seeded successfully!');
    }
}
