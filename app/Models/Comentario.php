<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'denuncia_id',
        'curso_id',
        'conteudo',
        'é_resposta',
        'comentario_pai_id',
        'é_moderado',
        'moderador_id',
    ];

    protected function casts(): array
    {
        return [
            'é_resposta' => 'boolean',
            'é_moderado' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relacionamentos
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function denuncia(): BelongsTo
    {
        return $this->belongsTo(Denuncia::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function comentarioPai(): BelongsTo
    {
        return $this->belongsTo(Comentario::class, 'comentario_pai_id');
    }

    public function respostas()
    {
        return $this->hasMany(Comentario::class, 'comentario_pai_id');
    }

    public function moderador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderador_id');
    }

    // Escopos
    public function scopePorDenuncia($query, $denunciaId)
    {
        return $query->where('denuncia_id', $denunciaId)->whereNull('comentario_pai_id');
    }

    public function scopePorCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId)->whereNull('comentario_pai_id');
    }

    public function scopePrincipal($query)
    {
        return $query->whereNull('comentario_pai_id');
    }
}
