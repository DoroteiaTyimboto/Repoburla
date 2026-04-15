<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Denuncia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'tipo',
        'url_suspeita',
        'evidencias',
        'status',
        'prioridade',
        'impacto_estimado',
        'tags',
        'localizacao',
        'data_incidente',
        'resultado_verificacao',
        'moderador_id',
        'data_resolucao',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'data_incidente' => 'date',
            'data_resolucao' => 'datetime',
            'evidencias' => 'array',
            'tags' => 'array',
            'resultado_verificacao' => 'array',
        ];
    }

    // Relacionamentos
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function moderador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderador_id');
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    // Escopos
    public function scopePendente($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeAprovado($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeRejeitado($query)
    {
        return $query->where('status', 'rejeitado');
    }

    public function scopeResolvido($query)
    {
        return $query->where('status', 'resolvido');
    }

    public function scopeAlta($query)
    {
        return $query->where('prioridade', 'alta');
    }

    public function getStatusBadgeColor(): string
    {
        return match($this->status) {
            'pendente' => 'warning',
            'aprovado' => 'info',
            'rejeitado' => 'danger',
            'resolvido' => 'success',
            default => 'secondary'
        };
    }

    public function markAsApproved($resultado = [])
    {
        $this->update([
            'status' => 'aprovado',
            'resultado_verificacao' => $resultado,
        ]);
        return $this;
    }

    public function markAsResolved()
    {
        $this->update([
            'status' => 'resolvido',
            'data_resolucao' => now(),
        ]);
        return $this;
    }
}
