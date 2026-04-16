<?php $__env->startSection('title', 'Admin - Usuários'); ?>

<?php $__env->startSection('admin-content'); ?>
<h1 class="page-title">Gerenciar Usuários</h1>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Perfil</th>
                        <th>Status</th>
                        <th>Cadastro</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($usuario->name); ?></td>
                            <td><?php echo e($usuario->email); ?></td>
                            <td><span class="badge bg-secondary"><?php echo e(ucfirst($usuario->role)); ?></span></td>
                            <td>
                                <span class="badge bg-<?php echo e($usuario->is_active ? 'success' : 'danger'); ?>">
                                    <?php echo e($usuario->is_active ? 'Ativo' : 'Inativo'); ?>

                                </span>
                            </td>
                            <td><?php echo e($usuario->created_at->format('d/m/Y')); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.usuarios.edit', $usuario)); ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                <?php if(auth()->id() !== $usuario->id): ?>
                                    <form action="<?php echo e(route('admin.usuarios.delete', $usuario)); ?>" method="POST" class="d-inline ms-1" onsubmit="return confirm('Tem certeza que deseja eliminar este usuário?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark border">Você</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Nenhum usuário encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($usuarios->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/usuarios/index.blade.php ENDPATH**/ ?>