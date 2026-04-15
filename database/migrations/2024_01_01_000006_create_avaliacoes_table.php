<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('denuncia_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('classificacao')->comment('1 a 5');
            $table->text('comentario')->nullable();
            $table->string('tipo_recurso')->comment('denuncia, curso');
            $table->timestamps();
            $table->index('user_id');
            $table->index('denuncia_id');
            $table->index('curso_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
