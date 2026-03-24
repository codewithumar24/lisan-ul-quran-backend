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
        Schema::create('tajweed_rules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('rule_category');
            $table->string('rule_name_english');
            $table->string('rule_name_arabic');
            $table->string('rule_name_urdu');
            $table->text('description_english');
            $table->text('description_urdu');
            $table->string('color_code')->nullable();
            $table->json('applicable_letters');
            $table->text('application_method_english');
            $table->text('application_method_urdu');
            $table->json('examples')->nullable();
            $table->string('audio_explanation')->nullable();
            $table->integer('difficulty_level')->default(1);
            $table->integer('display_order');
            $table->boolean('is_basic')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('rule_category');
            $table->index('display_order');
            $table->index('difficulty_level');
            $table->index('is_basic');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tajweed_rules');
    }
};
