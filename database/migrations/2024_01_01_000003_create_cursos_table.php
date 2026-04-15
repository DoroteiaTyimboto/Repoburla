<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->longText('conteudo')->nullable();
            $table->enum('nivel', ['iniciante', 'intermediario', 'avancado'])->default('iniciante');
            $table->integer('duracao_minutos')->default(0);
            $table->string('categoria')->nullable();
            $table->string('imagem_capa')->nullable();
            $table->json('instrucoes')->nullable();
            $table->json('tags')->nullable();
            $table->boolean('is_published')->default(false);
            $table->integer('ordem')->default(0);
            $table->timestamps();
            $table->index('categoria');
            $table->index('nivel');
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
