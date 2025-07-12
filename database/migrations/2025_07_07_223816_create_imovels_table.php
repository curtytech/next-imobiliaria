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
        Schema::create('imovels', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->string('tipo'); // casa, apartamento, terreno, comercial
            $table->string('status')->default('disponivel'); // disponivel, vendido, alugado
            $table->decimal('preco', 12, 2);
            $table->integer('area');
            $table->integer('quartos')->nullable();
            $table->integer('banheiros')->nullable();
            $table->integer('vagas_garagem')->nullable();
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado', 2);
            $table->string('cep', 8);
            $table->json('caracteristicas')->nullable(); // características extras
            $table->json('fotos')->nullable(); // URLs das fotos
            $table->json('videos')->nullable(); // URLs dos vídeos do YouTube
            $table->boolean('destaque')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imovels');
    }
};
