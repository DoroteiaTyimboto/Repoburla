<?php $__env->startSection('title', 'Editar Curso'); ?>

<?php $__env->startSection('admin-content'); ?>
<h1 class="page-title">Editar Curso</h1>

<div class="card">
    <div class="card-body">
        <form action="<?php echo e(route('admin.cursos.update', $curso)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="<?php echo e(old('titulo', $curso->titulo)); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4" required><?php echo e(old('descricao', $curso->descricao)); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Conteúdo</label>
                <textarea name="conteudo" class="form-control" rows="6"><?php echo e(old('conteudo', $curso->conteudo)); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nível</label>
                    <select name="nivel" class="form-select" required>
                        <option value="iniciante" <?php if(old('nivel', $curso->nivel) === 'iniciante'): echo 'selected'; endif; ?>>Iniciante</option>
                        <option value="intermediario" <?php if(old('nivel', $curso->nivel) === 'intermediario'): echo 'selected'; endif; ?>>Intermediário</option>
                        <option value="avancado" <?php if(old('nivel', $curso->nivel) === 'avancado'): echo 'selected'; endif; ?>>Avançado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Duração</label>
                    <input type="number" name="duracao_minutos" class="form-control" value="<?php echo e(old('duracao_minutos', $curso->duracao_minutos)); ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" name="categoria" class="form-control" value="<?php echo e(old('categoria', $curso->categoria)); ?>">
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="cursoPublicado" <?php if(old('is_published', $curso->is_published)): echo 'checked'; endif; ?>>
                <label class="form-check-label" for="cursoPublicado">Curso publicado</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?php echo e(route('admin.cursos')); ?>" class="btn btn-outline-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/cursos/edit.blade.php ENDPATH**/ ?>