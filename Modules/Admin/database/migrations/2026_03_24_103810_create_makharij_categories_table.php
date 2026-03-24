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
        Schema::create('makharij_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name_english');
            $table->string('name_arabic');
            $table->string('name_urdu');
            $table->text('description_english');
            $table->text('description_urdu');
            $table->string('icon')->nullable();
            $table->integer('display_order');
            $table->timestamps();
            $table->softDeletes();

            $table->index('display_order');
            $table->index('name_english');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makharij_categories');
    }
};
