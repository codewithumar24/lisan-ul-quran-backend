<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Entities\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'View Users'],
            ['name' => 'Create Users'],
            ['name' => 'Update Users'],
            ['name' => 'Delete Users'],
            ['name' => 'View Own Profile'],
            ['name' => 'Update Own Profile'],

            // Role Management
            ['name' => 'View Roles'],
            ['name' => 'Create Roles'],
            ['name' => 'Update Roles'],
            ['name' => 'Delete Roles'],
            ['name' => 'Assign Permissions'],

            // Permission Management
            ['name' => 'View Permissions'],
            ['name' => 'Create Permissions'],
            ['name' => 'Update Permissions'],
            ['name' => 'Delete Permissions'],

            // Arabic Letters
            ['name' => 'View Arabic Letters'],
            ['name' => 'Create Arabic Letters'],
            ['name' => 'Update Arabic Letters'],
            ['name' => 'Delete Arabic Letters'],

            // Makhraj Categories
            ['name' => 'View Makhraj Categories'],
            ['name' => 'Create Makhraj Categories'],
            ['name' => 'Update Makhraj Categories'],
            ['name' => 'Delete Makhraj Categories'],

            // Tajweed Rules
            ['name' => 'View Tajweed Rules'],
            ['name' => 'Create Tajweed Rules'],
            ['name' => 'Update Tajweed Rules'],
            ['name' => 'Delete Tajweed Rules'],

            // Lessons
            ['name' => 'View Lessons'],
            ['name' => 'Create Lessons'],
            ['name' => 'Update Lessons'],
            ['name' => 'Delete Lessons'],
            ['name' => 'Publish Lessons'],

            // Practice Exercises
            ['name' => 'View Practice Exercises'],
            ['name' => 'Create Practice Exercises'],
            ['name' => 'Update Practice Exercises'],
            ['name' => 'Delete Practice Exercises'],

            // Quizzes
            ['name' => 'View Quizzes'],
            ['name' => 'Create Quizzes'],
            ['name' => 'Update Quizzes'],
            ['name' => 'Delete Quizzes'],
            ['name' => 'Publish Quizzes'],

            // Quiz Questions
            ['name' => 'View Quiz Questions'],
            ['name' => 'Create Quiz Questions'],
            ['name' => 'Update Quiz Questions'],
            ['name' => 'Delete Quiz Questions'],

            // Audio Files
            ['name' => 'View Audio Files'],
            ['name' => 'Upload Audio Files'],
            ['name' => 'Update Audio Files'],
            ['name' => 'Delete Audio Files'],
            ['name' => 'Download Audio Files'],
            ['name' => 'View Audio Statistics'],

            // User Progress
            ['name' => 'View Own Progress'],
            ['name' => 'Track Lesson Progress'],
            ['name' => 'Record Practice'],
            ['name' => 'Submit Quiz Attempts'],
            ['name' => 'View All Users Progress'],
            ['name' => 'Export Progress Data'],

            // Dashboard
            ['name' => 'View Dashboard'],
            ['name' => 'View Analytics'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                ['uuid' => Str::uuid(),
                    'slug' => Str::slug($perm['name']),
                ]
            );
        }

        $this->command->info('Permissions seeded successfully: ' . count($permissions) . ' permissions created.');
    }
}
