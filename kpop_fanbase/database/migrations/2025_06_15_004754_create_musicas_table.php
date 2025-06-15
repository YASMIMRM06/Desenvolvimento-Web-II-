<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('musicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained()->onDelete('cascade');
            $table->string('titulo', 255);
            $table->integer('duracao')->comment('Duração em segundos');
            $table->date('data_lancamento');
            $table->string('youtube_id', 255)->nullable();
            $table->float('media_avaliacoes')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('musicas');
    }
};