<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'user_id',
        'denuncia_id',
        'curso_id',
        'classificacao',
        'comentario',
        'tipo_recurso',
    ];

    protected function casts(): array
    {
        return [
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

    // Escopos
    public function scopeParaDenuncia($query, $denunciaId)
    {
        return $query->where('denuncia_id', $denunciaId);
    }

    public function scopeParaCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    public function scopePositivas($query)
    {
        return $query->where('classificacao', '>=', 4);
    }

    public function scopeNegativas($query)
    {
        return $query->where('classificacao', '<', 3);
    }
}
