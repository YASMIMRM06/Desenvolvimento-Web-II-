<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('itens_colecionaveis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('nome', 255);
            $table->text('descricao');
            $table->enum('tipo', ['album', 'photocard', 'merchandising', 'outro']);
            $table->enum('estado', ['novo', 'seminovo', 'usado']);
            $table->boolean('disponivel_para_troca')->default(false);
            $table->string('foto', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('itens_colecionaveis');
    }
};