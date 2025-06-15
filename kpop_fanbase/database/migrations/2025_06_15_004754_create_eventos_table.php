<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criador_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('nome', 255);
            $table->text('descricao');
            $table->dateTime('data_evento');
            $table->string('localizacao', 255);
            $table->integer('capacidade');
            $table->enum('status', ['ativo', 'cancelado', 'concluido'])->default('ativo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('eventos');
    }
};