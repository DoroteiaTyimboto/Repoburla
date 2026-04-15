<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestadorLink extends Model
{
    use HasFactory;

    protected $table = 'testador_links';

    protected $fillable = [
        'user_id',
        'url_testada',
        'resultado',
        'classificacao_risco',
        'detalhes_verificacao',
        'tempo_verificacao',
        'ip_destino',
        'certificado_ssl',
        'reputacao_dominio',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'resultado' => 'array',
            'detalhes_verificacao' => 'array',
            'certificado_ssl' => 'array',
        ];
    }

    // Relacionamentos
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Escopos
    public function scopeSeguro($query)
    {
        return $query->where('classificacao_risco', 'seguro');
    }

    public function scopePotencialmentePeriogoso($query)
    {
        return $query->where('classificacao_risco', 'suspeito');
    }

    public function scopePeriogoso($query)
    {
        return $query->where('classificacao_risco', 'perigoso');
    }

    public function scopePorUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Métodos
    public function isSeguro(): bool
    {
        return $this->classificacao_risco === 'seguro';
    }

    public function isSuspeito(): bool
    {
        return $this->classificacao_risco === 'suspeito';
    }

    public function isPerigoso(): bool
    {
        return $this->classificacao_risco === 'perigoso';
    }

    public function getRiscoColor(): string
    {
        return match($this->classificacao_risco) {
            'seguro' => 'success',
            'suspeito' => 'warning',
            'perigoso' => 'danger',
            default => 'secondary'
        };
    }
}
