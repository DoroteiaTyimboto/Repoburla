<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Administração</h5>
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-primary text-start">Dashboard</a>
                        <a href="<?php echo e(route('admin.denuncias')); ?>" class="btn btn-outline-primary text-start">Denúncias</a>
                        <a href="<?php echo e(route('admin.usuarios')); ?>" class="btn btn-outline-primary text-start">Usuários</a>
                        <a href="<?php echo e(route('admin.cursos')); ?>" class="btn btn-outline-primary text-start">Cursos</a>
                        <a href="<?php echo e(route('admin.relatorios')); ?>" class="btn btn-outline-primary text-start">Relatórios</a>
                        <a href="<?php echo e(route('admin.notificacoes')); ?>" class="btn btn-outline-primary text-start">Notificações</a>
                        <a href="<?php echo e(route('admin.configuracoes')); ?>" class="btn btn-outline-primary text-start">Configurações</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <?php echo $__env->yieldContent('admin-content'); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/layout.blade.php ENDPATH**/ ?>