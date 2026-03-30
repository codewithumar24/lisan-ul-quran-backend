<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Entities\Permission;
use Modules\Core\Entities\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Get all permissions
        $allPermissions = Permission::all();

        // Admin Role (All permissions)
        $adminRole = Role::firstOrCreate(
            ['name' => 'Admin'],
            [
                'uuid' => Str::uuid(),
                'slug' => 'admin',
                'is_active' => true,
            ]
        );

        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Teacher Role (basic logic: exclude delete users)
        $teacherPermissions = Permission::where('name', 'NOT LIKE', '%Delete Users%')->pluck('id');

        $teacherRole = Role::firstOrCreate(
            ['name' => 'Teacher'],
            [
                'uuid' => Str::uuid(),
                'slug' => 'teacher',
                'is_active' => true,
            ]
        );

        $teacherRole->permissions()->sync($teacherPermissions);

        // Student Role (limited access)
        $studentPermissions = Permission::where('name', 'LIKE', 'View%')
            ->orWhere('name', 'LIKE', '%Own%')
            ->pluck('id');

        $studentRole = Role::firstOrCreate(
            ['name' => 'Student'],
            [
                'uuid' => Str::uuid(),
                'slug' => 'student',
                'is_active' => true,
            ]
        );

        $studentRole->permissions()->sync($studentPermissions);

        // Guest Role (read-only)
        $guestPermissions = Permission::where('name', 'LIKE', 'View%')->pluck('id');

        $guestRole = Role::firstOrCreate(
            ['name' => 'Guest'],
            [
                'uuid' => Str::uuid(),
                'slug' => 'guest',
                'is_active' => true,
            ]
        );

        $guestRole->permissions()->sync($guestPermissions);

        $this->command->info('Roles seeded successfully: Admin, Teacher, Student, Guest');
    }
}
