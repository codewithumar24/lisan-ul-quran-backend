<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title_english');
            $table->string('title_urdu');
            $table->string('title_arabic')->nullable();
            $table->text('description_english');
            $table->text('description_urdu');
            $table->enum('lesson_type', [
                'alphabet',
                'makhraj',
                'tajweed_rule',
                'practice',
                'quiz'
            ]);
            $table->integer('chapter_number');
            $table->integer('lesson_number');
            $table->json('content');
            $table->json('learning_objectives');
            $table->json('prerequisite_lessons')->nullable();
            $table->integer('estimated_minutes');
            $table->integer('difficulty_level')->default(1);
            $table->string('thumbnail_image')->nullable();
            $table->string('video_url')->nullable();
            $table->json('attachments')->nullable();
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('lesson_type');
            $table->index('chapter_number');
            $table->index('lesson_number');
            $table->index('difficulty_level');
            $table->index('is_published');
            $table->unique(['chapter_number', 'lesson_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
