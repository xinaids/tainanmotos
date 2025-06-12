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
        Schema::create('manutencaos', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 8);
            $table->unsignedBigInteger('marca');
            $table->unsignedBigInteger('modelo');
            $table->string('cor');
            $table->integer('quilometragem');
            $table->integer('ano');
            $table->text('descricao');
            $table->bigInteger('usuario_cpf');
            $table->date('data_abertura');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manutencaos');
    }
};
