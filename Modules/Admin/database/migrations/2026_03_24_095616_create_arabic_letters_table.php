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
        Schema::create('arabic_letters', function (Blueprint $table) {
           $table->id();
            $table->uuid('uuid')->unique();
            $table->string('letter_arabic', 10);
            $table->string('letter_name_arabic');
            $table->string('letter_name_urdu');
            $table->string('letter_name_english');
            $table->string('makhraj_category');
            $table->text('makhraj_description_urdu');
            $table->text('makhraj_description_english');
            $table->text('pronunciation_tips_urdu');
            $table->text('pronunciation_tips_english');
            $table->string('audio_file_letter')->nullable();
            $table->string('audio_file_makhraj')->nullable();
            $table->string('shape_isolated');
            $table->string('shape_initial')->nullable();
            $table->string('shape_middle')->nullable();
            $table->string('shape_final')->nullable();
            $table->integer('display_order');
            $table->json('similar_urdu_sounds')->nullable();
            $table->json('common_mistakes_urdu')->nullable();
            $table->json('common_mistakes_english')->nullable();
            $table->boolean('has_ghunnah')->default(false);
            $table->boolean('is_qalqalah')->default(false);
            $table->boolean('is_madd_letter')->default(false);
            $table->string('makhraj_diagram')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index('display_order');
            $table->index('makhraj_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arabic_letters');
    }
};
