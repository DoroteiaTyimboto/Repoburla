<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testador_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('url_testada');
            $table->json('resultado')->nullable();
            $table->enum('classificacao_risco', ['seguro', 'suspeito', 'perigoso'])->default('suspeito');
            $table->json('detalhes_verificacao')->nullable();
            $table->integer('tempo_verificacao')->comment('em milissegundos');
            $table->string('ip_destino')->nullable();
            $table->json('certificado_ssl')->nullable();
            $table->string('reputacao_dominio')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('classificacao_risco');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testador_links');
    }
};
