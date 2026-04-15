<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('denuncias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('descricao');
            $table->enum('tipo', ['phishing', 'malware', 'fraude', 'roubo_identidade', 'spam', 'outro'])->default('outro');
            $table->string('url_suspeita')->nullable();
            $table->json('evidencias')->nullable();
            $table->enum('status', ['pendente', 'aprovado', 'rejeitado', 'resolvido'])->default('pendente');
            $table->enum('prioridade', ['baixa', 'media', 'alta'])->default('media');
            $table->integer('impacto_estimado')->default(0);
            $table->json('tags')->nullable();
            $table->string('localizacao')->nullable();
            $table->date('data_incidente')->nullable();
            $table->json('resultado_verificacao')->nullable();
            $table->foreignId('moderador_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('data_resolucao')->nullable();
            $table->timestamps();
            $table->index('status');
            $table->index('prioridade');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
