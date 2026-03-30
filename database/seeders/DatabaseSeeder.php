<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Admin\Database\Seeders\ArabicLetterSeeder;
use Modules\Admin\Database\Seeders\LessonSeeder;
use Modules\Admin\Database\Seeders\MakhrajCategorySeeder;
use Modules\Admin\Database\Seeders\PracticeExerciseSeeder;
use Modules\Admin\Database\Seeders\QuizSeeder;
use Modules\Admin\Database\Seeders\TajweedRuleSeeder;
use Modules\Core\Database\Seeders\PermissionSeeder;
use Modules\Core\Database\Seeders\RoleSeeder;
use Modules\User\Database\Seeders\AdminUserSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting Quran App Database Seeding...');
        $this->command->info('=====================================');

        // Core Module - Permissions and Roles
        $this->command->info("\nSeeding Permissions...");
        $this->call(PermissionSeeder::class);

        $this->command->info("\nSeeding Roles...");
        $this->call(RoleSeeder::class);

        // Admin Module - Content
        $this->command->info("\nSeeding Makhraj Categories...");
        $this->call(MakhrajCategorySeeder::class);

        $this->command->info("\nSeeding Arabic Letters...");
        $this->call(ArabicLetterSeeder::class);

        $this->command->info("\nSeeding Tajweed Rules...");
        $this->call(TajweedRuleSeeder::class);

        $this->command->info("\nSeeding Lessons...");
        $this->call(LessonSeeder::class);

        $this->command->info("\nSeeding Practice Exercises...");
        $this->call(PracticeExerciseSeeder::class);

        $this->command->info("\nSeeding Quizzes...");
        $this->call(QuizSeeder::class);

        // User Module - Users
        $this->command->info("\nSeeding Admin Users...");
        $this->call(AdminUserSeeder::class);

        $this->command->info("\n=====================================");
        $this->command->info('Database seeding completed successfully!');
        $this->command->info('You can now login with the following credentials:');
        $this->command->info('Admin: admin@lisanulquran.com / Admin@123');
        $this->command->info('Teacher: teacher@lisanulquran.com / Teacher@123');
        $this->command->info('Student: student@lisanulquran.com / Student@123');

    }
}
