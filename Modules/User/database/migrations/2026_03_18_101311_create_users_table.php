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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('cnic')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->string('profile_photo')->nullable();
            $table->enum('language_preference', ['urdu', 'english', 'arabic'])->default('urdu');
            $table->enum('student_type', ['military', 'civilian'])->nullable();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('google_id')->nullable();
            $table->string('google_avatar')->nullable();
            $table->string('google_token')->nullable();
            $table->string('google_refresh_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
