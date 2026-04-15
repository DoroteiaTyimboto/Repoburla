<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'conteudo',
        'nivel',
        'duracao_minutos',
        'categoria',
        'imagem_capa',
        'instrucoes',
        'tags',
        'is_published',
        'ordem',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'tags' => 'array',
            'instrucoes' => 'array',
        ];
    }

    // Relacionamentos
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'curso_user')
            ->withTimestamps()
            ->withPivot('progresso', 'concluido_em');
    }

    public function avaliacoes(): HasMany
    {
        return $this->hasMany(Avaliacao::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(Comentario::class);
    }

    // Escopos
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeByNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    public function getMediaAvaliacoes()
    {
        $avaliacoes = $this->avaliacoes;
        if($avaliacoes->isEmpty()) return 0;
        return round($avaliacoes->avg('classificacao'), 1);
    }

    public function getTotalInscritos()
    {
        return $this->usuarios()->count();
    }

    public function getTotalConcluido()
    {
        return $this->usuarios()
            ->wherePivot('concluido_em', '!=', null)
            ->count();
    }

    public function getTaxaConclusao()
    {
        $total = $this->getTotalInscritos();
        if($total === 0) return 0;
        return round(($this->getTotalConcluido() / $total) * 100, 1);
    }
}
