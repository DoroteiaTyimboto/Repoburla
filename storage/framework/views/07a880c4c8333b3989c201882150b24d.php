<?php $__env->startSection('title', 'Editar Usuário'); ?>

<?php $__env->startSection('admin-content'); ?>
<h1 class="page-title">Editar Usuário</h1>

<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('admin.usuarios.update', $user)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Perfil</label>
                    <select name="role" class="form-select" required>
                        <option value="user" <?php if(old('role', $user->role) === 'user'): echo 'selected'; endif; ?>>Usuário</option>
                        <option value="moderator" <?php if(old('role', $user->role) === 'moderator'): echo 'selected'; endif; ?>>Moderador</option>
                        <option value="admin" <?php if(old('role', $user->role) === 'admin'): echo 'selected'; endif; ?>>Admin</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?php if((string) old('is_active', (int) $user->is_active) === '1'): echo 'selected'; endif; ?>>Ativo</option>
                        <option value="0" <?php if((string) old('is_active', (int) $user->is_active) === '0'): echo 'selected'; endif; ?>>Inativo</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('admin.usuarios')); ?>" class="btn btn-outline-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/usuarios/edit.blade.php ENDPATH**/ ?>