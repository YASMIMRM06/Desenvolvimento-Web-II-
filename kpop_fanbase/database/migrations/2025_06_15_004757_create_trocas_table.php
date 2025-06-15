<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trocas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_ofertante_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('user_receptor_id')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('item_ofertante_id')->constrained('itens_colecionaveis')->onDelete('cascade');
            $table->foreignId('item_desejado_id')->constrained('itens_colecionaveis')->onDelete('cascade');
            $table->enum('status', ['pendente', 'aceito', 'recusado', 'cancelado', 'concluido'])->default('pendente');
            $table->text('mensagem')->nullable();
            $table->dateTime('data_proposta');
            $table->dateTime('data_conclusao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trocas');
    }
};