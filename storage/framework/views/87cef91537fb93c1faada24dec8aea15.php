<?php $__env->startSection('title', 'Minhas Denúncias'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="page-title">Minhas Denúncias</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="<?php echo e(route('denuncias.create')); ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nova Denúncia
            </a>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $denuncias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title"><?php echo e($denuncia->titulo); ?></h5>
                            <span class="badge badge-status-<?php echo e($denuncia->status); ?>">
                                <?php echo e(ucfirst($denuncia->status)); ?>

                            </span>
                        </div>

                        <p class="card-text text-muted"><?php echo e(\Illuminate\Support\Str::limit($denuncia->descricao, 150)); ?></p>

                        <div class="mb-3">
                            <span class="badge bg-secondary"><?php echo e(ucfirst($denuncia->tipo)); ?></span>
                            <span class="badge" style="background-color: <?php echo e(match($denuncia->prioridade) { 'alta' => '#e74c3c', 'media' => '#f39c12', 'baixa' => '#27ae60' }); ?>;">
                                <?php echo e(ucfirst($denuncia->prioridade)); ?>

                            </span>
                        </div>

                        <div class="small text-muted mb-3">
                            <i class="bi bi-calendar"></i> <?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?>

                        </div>

                        <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detalhes
                        </a>
                        <?php if($denuncia->status === 'pendente'): ?>
                            <a href="<?php echo e(route('denuncias.edit', $denuncia)); ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Você ainda não criou nenhuma denúncia.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <?php echo e($denuncias->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/denuncias/my-reports.blade.php ENDPATH**/ ?>