<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TestadorLink;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'country',
        'role',
        'is_active',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Relacionamentos
    public function denuncias(): HasMany
    {
        return $this->hasMany(Denuncia::class);
    }

    public function cursosInscritos()
    {
        return $this->belongsToMany(Curso::class, 'curso_user')
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

    public function notificacoes(): HasMany
    {
        return $this->hasMany(Notificacao::class)->orderBy('created_at', 'desc');
    }

    public function testadorLinks(): HasMany
    {
        return $this->hasMany(TestadorLink::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['admin', 'moderator']);
    }
}
