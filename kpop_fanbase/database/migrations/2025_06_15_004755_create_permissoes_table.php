<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permissoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100)->unique();
            $table->string('descricao', 255)->nullable();
            $table->timestamps();
        });

        // Inserir permissões básicas
        DB::table('permissoes')->insert([
            ['nome' => 'admin', 'descricao' => 'Acesso total ao sistema'],
            ['nome' => 'gerente', 'descricao' => 'Pode gerenciar grupos e eventos'],
            ['nome' => 'moderador', 'descricao' => 'Pode moderar conteúdo'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('permissoes');
    }
};