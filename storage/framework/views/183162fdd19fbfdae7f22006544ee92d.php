<?php $__env->startSection('title', 'Mapa de Denúncias'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="page-title">Mapa de Denúncias</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p class="lead mb-3">
                Acompanhe as denúncias registradas por localização. Esta visão ajuda a identificar áreas com maior concentração de casos reportados.
            </p>

            <?php
                $porLocalizacao = $denuncias
                    ->groupBy('localizacao')
                    ->map(fn ($grupo) => [
                        'total' => $grupo->count(),
                        'pendente' => $grupo->where('status', 'pendente')->count(),
                        'aprovado' => $grupo->where('status', 'aprovado')->count(),
                        'resolvido' => $grupo->where('status', 'resolvido')->count(),
                    ])
                    ->sortByDesc('total');
            ?>

            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <h3 class="fw-bold"><?php echo e($denuncias->count()); ?></h3>
                    <small class="text-muted">Denúncias com localização</small>
                </div>
                <div class="col-md-4 mb-3">
                    <h3 class="fw-bold"><?php echo e($porLocalizacao->count()); ?></h3>
                    <small class="text-muted">Localizações registradas</small>
                </div>
                <div class="col-md-4 mb-3">
                    <h3 class="fw-bold"><?php echo e($porLocalizacao->keys()->first() ?? 'N/A'); ?></h3>
                    <small class="text-muted">Local com mais ocorrências</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Resumo por Localização</h5>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $porLocalizacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localizacao => $dados): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong><?php echo e($localizacao); ?></strong>
                                <span class="badge bg-primary"><?php echo e($dados['total']); ?></span>
                            </div>
                            <div class="small text-muted">
                                Pendentes: <?php echo e($dados['pendente']); ?> |
                                Aprovadas: <?php echo e($dados['aprovado']); ?> |
                                Resolvidas: <?php echo e($dados['resolvido']); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Ainda não existem denúncias com localização informada.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Denúncias Registradas</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $denuncias->sortByDesc('created_at'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="me-3">
                                        <h6 class="mb-1"><?php echo e($denuncia->titulo); ?></h6>
                                        <p class="mb-1 text-muted">
                                            <?php echo e(\Illuminate\Support\Str::limit($denuncia->descricao, 120)); ?>

                                        </p>
                                        <div class="small">
                                            <span class="badge bg-info text-dark"><?php echo e($denuncia->localizacao); ?></span>
                                            <span class="badge badge-status-<?php echo e($denuncia->status); ?>"><?php echo e(ucfirst($denuncia->status)); ?></span>
                                            <span class="badge bg-<?php echo e(getPrioridadeColor($denuncia->prioridade)); ?>"><?php echo e(ucfirst($denuncia->prioridade)); ?></span>
                                        </div>
                                    </div>
                                    <small class="text-muted text-nowrap"><?php echo e($denuncia->created_at->format('d/m/Y')); ?></small>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted text-center py-4">Nenhuma denúncia localizada encontrada.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/mapa.blade.php ENDPATH**/ ?>