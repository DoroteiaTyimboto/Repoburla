<?php

namespace App\Providers;

use App\Events\SystemUpdated;
use App\Models\Avaliacao;
use App\Models\Comentario;
use App\Models\Curso;
use App\Models\Denuncia;
use App\Models\Notificacao;
use App\Models\TestadorLink;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('moderate', fn (User $user) => $user->isModerator());
        Gate::define('admin', fn (User $user) => $user->isAdmin());

        $realtimeModels = [
            User::class,
            Denuncia::class,
            Curso::class,
            Comentario::class,
            Avaliacao::class,
            Notificacao::class,
            TestadorLink::class,
        ];

        foreach ($realtimeModels as $modelClass) {
            $entity = strtolower(class_basename($modelClass));

            $modelClass::created(function ($model) use ($entity) {
                event(new SystemUpdated($entity, 'created', $model->getKey()));
            });

            $modelClass::updated(function ($model) use ($entity) {
                event(new SystemUpdated($entity, 'updated', $model->getKey()));
            });

            $modelClass::deleted(function ($model) use ($entity) {
                event(new SystemUpdated($entity, 'deleted', $model->getKey()));
            });
        }
    }
}
