<?php $__env->startSection('title', 'Admin - Cursos'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Gerenciar Cursos</h1>
    <a href="<?php echo e(route('admin.cursos.create')); ?>" class="btn btn-primary">Novo Curso</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Nível</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($curso->titulo); ?></td>
                            <td><?php echo e(ucfirst($curso->nivel)); ?></td>
                            <td><?php echo e($curso->categoria ?? 'Geral'); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($curso->is_published ? 'success' : 'secondary'); ?>">
                                    <?php echo e($curso->is_published ? 'Publicado' : 'Rascunho'); ?>

                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="<?php echo e(route('admin.cursos.edit', $curso)); ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="<?php echo e(route('admin.cursos.delete', $curso)); ?>" method="POST" onsubmit="return confirm('Tem certeza que deseja eliminar este curso?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum curso encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($cursos->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/cursos/index.blade.php ENDPATH**/ ?>