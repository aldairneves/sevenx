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
        Schema::create('movimentacoes_financeiras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')
                ->nullable()
                ->constrained('categorias_financeiras')
                ->nullOnDelete();
            $table->string('descricao');
            $table->text('observacao')->nullable();
            $table->decimal('valor', 12, 2);
            $table->enum('tipo', ['entrada', 'saida']);
            $table->date('data_movimentacao');
            $table->boolean('recorrente')->default(false);
            $table->timestamps();
            $table->index(['tipo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_financeiras');
    }
};
