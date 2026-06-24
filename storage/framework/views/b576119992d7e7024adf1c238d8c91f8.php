<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('admin-content'); ?>
<h1 class="page-title">Painel Administrativo</h1>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Usuários</h6>
                <h2 class="fw-bold text-primary"><?php echo e($stats['totalUsuarios']); ?></h2>
                <small class="text-muted">Ativos: <?php echo e($stats['usuariosAtivos']); ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Denúncias</h6>
                <h2 class="fw-bold text-danger"><?php echo e($stats['totalDenuncias']); ?></h2>
                <small class="text-muted">Pendentes: <?php echo e($stats['denunciasPendentes']); ?></small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Cursos</h6>
                <h2 class="fw-bold text-success"><?php echo e($stats['totalCursos']); ?></h2>
                <small class="text-muted">Publicados: <?php echo e($stats['cursosPublicados']); ?></small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Denúncias Pendentes</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php $__empty_1 = true; $__currentLoopData = $denunciasPendentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="list-group-item list-group-item-action">
                            <strong><?php echo e($denuncia->titulo); ?></strong>
                            <div class="small text-muted mt-1">
                                <?php echo e($denuncia->prioridade); ?> | <?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?>

                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-muted text-center py-4">Nenhuma denúncia pendente.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Usuários Recentes</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <?php $__empty_1 = true; $__currentLoopData = $usuariosRecentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="list-group-item">
                            <strong><?php echo e($usuario->name); ?></strong>
                            <div class="small text-muted mt-1">
                                <?php echo e($usuario->email); ?> | <?php echo e(ucfirst($usuario->role)); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-muted text-center py-4">Nenhum usuário recente.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>