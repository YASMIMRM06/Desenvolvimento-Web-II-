<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('participacao_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->boolean('confirmado')->default(false);
            $table->timestamps();
            
            $table->unique(['user_id', 'evento_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('participacao_eventos');
    }
};