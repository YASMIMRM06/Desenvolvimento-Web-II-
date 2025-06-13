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
        // database/migrations/2025_06_01_000000_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->date('birth_date');
    $table->enum('type', ['fan', 'manager', 'admin']);
    $table->string('profile_picture')->nullable();
    $table->rememberToken();
    $table->timestamps();
});
        // database/migrations/2025_06_01_000001_create_extended_profiles_table.php
        Schema::create('extended_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('bio')->nullable();
            $table->string('location')->nullable();
            $table->string('social_links')->nullable(); // JSON or text field for multiple links
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extended_profiles');
        Schema::dropIfExists('users');
    }
};
