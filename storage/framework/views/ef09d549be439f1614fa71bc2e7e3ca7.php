<?php $__env->startSection('title', 'Relatórios'); ?>

<?php $__env->startSection('admin-content'); ?>
<h1 class="page-title">Relatórios</h1>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Denúncias por Tipo</h5></div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $relatorios['denunciasPorTipo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><?php echo e(ucfirst($tipo ?? 'Não informado')); ?></span>
                        <strong><?php echo e($total); ?></strong>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-muted">Sem dados.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Denúncias por Status</h5></div>
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $relatorios['denunciasPorStatus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span><?php echo e(ucfirst($status)); ?></span>
                        <strong><?php echo e($total); ?></strong>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-muted">Sem dados.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/relatorios.blade.php ENDPATH**/ ?>