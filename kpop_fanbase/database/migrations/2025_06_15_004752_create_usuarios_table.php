<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('email', 255)->unique();
            $table->string('senha');
            $table->date('data_nascimento')->nullable();
            $table->enum('tipo', ['fã', 'gerente', 'admin'])->default('fã');
            $table->string('foto_perfil', 255)->nullable();
            $table->timestamp('email_verificado_at')->nullable();
            $table->boolean('email_verificado')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};