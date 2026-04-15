<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('denuncia_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('conteudo');
            $table->boolean('é_resposta')->default(false);
            $table->foreignId('comentario_pai_id')->nullable()->constrained('comentarios')->onDelete('cascade');
            $table->boolean('é_moderado')->default(false);
            $table->foreignId('moderador_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->index('user_id');
            $table->index('denuncia_id');
            $table->index('curso_id');
            $table->index('comentario_pai_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
