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
        Schema::create('practice_exercises', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->string('title_english');
            $table->string('title_urdu');
            $table->enum('exercise_type', [
                'repetition',
                'pronunciation',
                'identification',
                'listening',
                'recording'
            ]);
            $table->text('instructions_english');
            $table->text('instructions_urdu');
            $table->json('content');
            $table->json('correct_response')->nullable();
            $table->json('options')->nullable();
            $table->string('audio_prompt')->nullable();
            $table->string('correct_audio')->nullable();
            $table->integer('points')->default(10);
            $table->integer('difficulty_level')->default(1);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('exercise_type');
            $table->index('difficulty_level');
            $table->index(['lesson_id', 'display_order']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practice_exercises');
    }
};
