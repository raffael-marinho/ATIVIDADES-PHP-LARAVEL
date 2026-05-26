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
    Schema::create('movies', function (Blueprint $table) {
        $table->id();
        $table->string('title');                // VARCHAR para o Título
        $table->text('description');            // TEXT para a Descrição longa
        $table->integer('duration');            // INT para a Duração em minutos
        $table->string('category');             // VARCHAR para a Categoria
        $table->decimal('budget', 15, 2);       // DECIMAL (15 dígitos, 2 decimais) para Orçamento
        $table->string('language');             // VARCHAR para o Idioma
        $table->timestamps();                   // Cria as colunas created_at e updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
