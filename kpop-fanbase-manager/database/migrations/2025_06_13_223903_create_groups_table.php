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
       // database/migrations/2025_06_01_000002_create_groups_table.php
Schema::create('groups', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->date('debut_date');
    $table->string('company');
    $table->text('description');
    $table->string('photo');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
