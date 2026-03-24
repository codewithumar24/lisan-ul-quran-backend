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

        // Define permissions
        $permissions = [
            // User permissions
            ['name' => 'View Users', 'group' => 'User'],
            ['name' => 'Create Users', 'group' => 'User'],
            ['name' => 'Update Users', 'group' => 'User'],
            ['name' => 'Delete Users', 'group' => 'User'],

            // Role permissions
            ['name' => 'View Roles', 'group' => 'Role'],
            ['name' => 'Create Roles', 'group' => 'Role'],
            ['name' => 'Update Roles', 'group' => 'Role'],
            ['name' => 'Delete Roles', 'group' => 'Role'],

            // Permission permissions
            ['name' => 'View Permissions', 'group' => 'Permission'],
            ['name' => 'Create Permissions', 'group' => 'Permission'],
            ['name' => 'Update Permissions', 'group' => 'Permission'],
            ['name' => 'Delete Permissions', 'group' => 'Permission'],

            // Class permissions (from your example)
            ['name' => 'Get Classes', 'group' => 'Class'],
            ['name' => 'Create Class', 'group' => 'Class'],
            ['name' => 'Update Class', 'group' => 'Class'],
            ['name' => 'Delete Class', 'group' => 'Class'],
            ['name' => 'View Class', 'group' => 'Class'],


            ['name' => 'View Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'Create Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'Update Arabic Letters', 'group' => 'Arabic Letters'],
            ['name' => 'Delete Arabic Letters', 'group' => 'Arabic Letters'],
        ];

        // Create permissions
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                [
                    'slug' => str($perm['name'])->slug(),
                    'group' => $perm['group'],
                ]
            );
        }

        // Create roles
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

        // Assign all permissions to admin
        $adminRole->permissions()->sync(Permission::all());

        // Assign specific permissions to teacher
        $teacherPermissions = Permission::whereIn('group', ['Class'])->pluck('id');
        $teacherRole->permissions()->sync($teacherPermissions);

        $this->info('Roles and permissions seeded successfully!');
    }
}
