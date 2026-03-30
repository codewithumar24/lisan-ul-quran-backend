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
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question_english');
            $table->text('question_urdu');
            $table->enum('question_type', [
                'multiple_choice',
                'true_false',
                'matching',
                'audio_identification',
                'pronunciation_check'
            ]);
            $table->json('options');
            $table->json('correct_answers');
            $table->text('explanation_english')->nullable();
            $table->text('explanation_urdu')->nullable();
            $table->string('audio_file')->nullable();
            $table->string('image_file')->nullable();
            $table->integer('points')->default(1);
            $table->integer('difficulty_level')->default(1);
            $table->integer('display_order');
            $table->timestamps();
            $table->softDeletes();

            $table->index('question_type');
            $table->index('difficulty_level');
            $table->index(['quiz_id', 'display_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
    }
};
