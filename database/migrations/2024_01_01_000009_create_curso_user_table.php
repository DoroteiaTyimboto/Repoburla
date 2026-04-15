<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curso_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->integer('progresso')->default(0)->comment('Percentual de progresso');
            $table->timestamp('concluido_em')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'curso_id']);
            $table->index(['user_id', 'concluido_em']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curso_user');
    }
};
