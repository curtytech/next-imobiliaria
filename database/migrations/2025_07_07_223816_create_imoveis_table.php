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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->enum('situacao', ['vende-se', 'aluga-se'])->default('vende-se');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('tipo_id')->constrained('tipos_imoveis');
            $table->foreignId('status_id')->constrained('status_imovels')->default(1);
            $table->decimal('preco', 12, 2);
            $table->decimal('preco_iptu', 12, 2)->nullable();
            $table->decimal('preco_condominio', 12, 2)->nullable();
            $table->integer('area');
            $table->integer('quartos')->nullable();
            $table->integer('banheiros')->nullable();
            $table->integer('vagas_garagem')->nullable();
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('pais');
            $table->string('cep', 15);
            $table->json('caracteristicas')->nullable(); // características extras
            $table->json('fotos')->nullable(); // URLs das fotos
            $table->json('videos')->nullable(); // URLs dos vídeos do YouTube
            $table->boolean('destaque')->default(false);            
            $table->string('localizacao_maps')->nullable();
            $table->decimal('area_util', 8, 2)->nullable();
            $table->decimal('terreno', 8, 2)->nullable();
            $table->decimal('area_constr', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};
