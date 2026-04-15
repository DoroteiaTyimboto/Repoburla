<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tipo', ['denuncia', 'curso', 'comentario', 'sistema'])->default('sistema');
            $table->string('titulo');
            $table->text('mensagem');
            $table->string('url')->nullable();
            $table->boolean('é_lida')->default(false);
            $table->json('dados_adicionais')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('é_lida');
            $table->index('tipo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificacoes');
    }
};
