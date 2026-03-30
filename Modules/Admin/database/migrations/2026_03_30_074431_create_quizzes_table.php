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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title_english');
            $table->string('title_urdu');
            $table->text('description_english');
            $table->text('description_urdu');
            $table->enum('quiz_type', [
                'lesson_quiz',
                'chapter_quiz',
                'final_assessment'
            ]);
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('chapter_number')->nullable();
            $table->integer('time_limit_minutes')->nullable();
            $table->integer('passing_score_percentage')->default(70);
            $table->integer('total_questions')->default(0);
            $table->integer('max_attempts')->default(3);
            $table->boolean('show_answers_after')->default(true);
            $table->boolean('is_published')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('quiz_type');
            $table->index('is_published');
            $table->index('chapter_number');
            $table->index(['lesson_id', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
