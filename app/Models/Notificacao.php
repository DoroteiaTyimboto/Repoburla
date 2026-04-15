<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacoes';

    protected $fillable = [
        'user_id',
        'tipo',
        'titulo',
        'mensagem',
        'url',
        'é_lida',
        'dados_adicionais',
    ];

    protected function casts(): array
    {
        return [
            'é_lida' => 'boolean',
            'dados_adicionais' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relacionamentos
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Escopos
    public function scopeNaoLidas($query)
    {
        return $query->where('é_lida', false);
    }

    public function scopeLidas($query)
    {
        return $query->where('é_lida', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Métodos
    public function markAsRead()
    {
        $this->update(['é_lida' => true]);
        return $this;
    }

    public function markAsUnread()
    {
        $this->update(['é_lida' => false]);
        return $this;
    }
}
