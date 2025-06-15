<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('musica_id')->constrained('musicas')->onDelete('cascade');
            $table->integer('nota')->unsigned()->between(1, 5);
            $table->text('comentario')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'musica_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliacoes');
    }
};