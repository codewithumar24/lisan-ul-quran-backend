<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Entities\Role;
use Modules\User\Entities\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        // Create Super Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@lisanulquran.com'],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@lisanulquran.com',
                'password' => Hash::make('Admin123'),
                'role_id' => $adminRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language_preference' => 'english',
            ]
        );

        // Create Test Teacher
        $teacherRole = Role::where('name', 'Teacher')->first();
        $teacher = User::firstOrCreate(
            ['email' => 'teacher@lisanulquran.com'],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'Test',
                'last_name' => 'Teacher',
                'email' => 'teacher@lisanulquran.com',
                'password' => Hash::make('Teacher@123'),
                'role_id' => $teacherRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language_preference' => 'english',
            ]
        );

        // Create Test Student
        $studentRole = Role::where('name', 'Student')->first();
        $student = User::firstOrCreate(
            ['email' => 'student@lisanulquran.com'],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'Test',
                'last_name' => 'Student',
                'email' => 'student@lisanulquran.com',
                'password' => Hash::make('Student@123'),
                'role_id' => $studentRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language_preference' => 'urdu',
                'student_type' => 'civilian',
            ]
        );

        // Create Urdu Speaking Student
        $urduStudent = User::firstOrCreate(
            ['email' => 'urdu.student@lisanulquran.com'],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'first_name' => 'Urdu',
                'last_name' => 'Student',
                'email' => 'urdu.student@lisanulquran.com',
                'password' => Hash::make('Student@123'),
                'role_id' => $studentRole->id,
                'is_active' => true,
                'email_verified_at' => now(),
                'language_preference' => 'urdu',
                'student_type' => 'civilian',
                'country' => 'Pakistan',
                'city' => 'Karachi',
                'phone' => '+923001234567',
            ]
        );

        $this->command->info('Admin users seeded successfully:');
        $this->command->info('Admin Email: admin@lisanulquran.com | Password: Admin@123');
        $this->command->info('Teacher Email: teacher@lisanulquran.com | Password: Teacher@123');
        $this->command->info('Student Email: student@lisanulquran.com | Password: Student@123');
    }
}
