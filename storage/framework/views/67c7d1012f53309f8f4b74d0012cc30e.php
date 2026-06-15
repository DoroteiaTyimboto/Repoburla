<?php $__env->startSection('title', 'Minhas Notificações'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Minhas Notificações</h1>
        <form action="<?php echo e(route('notificacoes.read-all')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-outline-primary">Marcar todas como lidas</button>
        </form>
    </div>

    <div class="card">
        <div class="list-group list-group-flush">
            <?php $__empty_1 = true; $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notificacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="list-group-item py-3">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0"><?php echo e($notificacao->titulo); ?></h6>
                                <?php if(!$notificacao->é_lida): ?>
                                    <span class="badge bg-danger">Nova</span>
                                <?php endif; ?>
                            </div>
                            <p class="text-muted small mb-2"><?php echo e($notificacao->mensagem); ?></p>
                            <small class="text-muted"><?php echo e($notificacao->created_at->format('d/m/Y H:i')); ?></small>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <?php if($notificacao->url): ?>
                                <a href="<?php echo e($notificacao->url); ?>" class="btn btn-sm btn-outline-primary">Abrir</a>
                            <?php endif; ?>
                            <?php if(!$notificacao->é_lida): ?>
                                <form action="<?php echo e(route('notificacoes.read', $notificacao)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Marcar lida</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="list-group-item py-4 text-center text-muted">
                    Nenhuma notificação encontrada.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-4">
        <?php echo e($notificacoes->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/notificacoes/index.blade.php ENDPATH**/ ?>