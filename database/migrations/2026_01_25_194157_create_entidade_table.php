<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entidade', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->enum('tipo', ['propriedade', 'instituicao']);
            $table->string('cnpj_cpf', 20)->nullable();
            $table->enum('status', ['ativo', 'inativo'])
                ->default('inativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entidade');
    }
};
