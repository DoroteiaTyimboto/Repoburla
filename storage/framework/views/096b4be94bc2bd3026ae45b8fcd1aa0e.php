<?php $__env->startSection('title', 'Admin - Denúncias'); ?>

<?php $__env->startSection('admin-content'); ?>
<h1 class="page-title">Gerenciar Denúncias</h1>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?php echo e(route('admin.denuncias.filter')); ?>" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="busca" class="form-control" placeholder="Buscar..." value="<?php echo e(request('busca')); ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Todos os status</option>
                    <option value="pendente" <?php if(request('status') === 'pendente'): echo 'selected'; endif; ?>>Pendente</option>
                    <option value="aprovado" <?php if(request('status') === 'aprovado'): echo 'selected'; endif; ?>>Aprovado</option>
                    <option value="resolvido" <?php if(request('status') === 'resolvido'): echo 'selected'; endif; ?>>Resolvido</option>
                    <option value="rejeitado" <?php if(request('status') === 'rejeitado'): echo 'selected'; endif; ?>>Rejeitado</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="prioridade" class="form-select">
                    <option value="">Todas as prioridades</option>
                    <option value="alta" <?php if(request('prioridade') === 'alta'): echo 'selected'; endif; ?>>Alta</option>
                    <option value="media" <?php if(request('prioridade') === 'media'): echo 'selected'; endif; ?>>Média</option>
                    <option value="baixa" <?php if(request('prioridade') === 'baixa'): echo 'selected'; endif; ?>>Baixa</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="tipo" class="form-select">
                    <option value="">Todos os tipos</option>
                    <option value="phishing" <?php if(request('tipo') === 'phishing'): echo 'selected'; endif; ?>>Phishing</option>
                    <option value="malware" <?php if(request('tipo') === 'malware'): echo 'selected'; endif; ?>>Malware</option>
                    <option value="fraude" <?php if(request('tipo') === 'fraude'): echo 'selected'; endif; ?>>Fraude</option>
                </select>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Localização</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $denuncias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <strong><?php echo e($denuncia->titulo); ?></strong>
                                <div class="small text-muted"><?php echo e(\Illuminate\Support\Str::limit($denuncia->descricao, 80)); ?></div>
                            </td>
                            <td><?php echo e(ucfirst($denuncia->tipo ?? 'N/A')); ?></td>
                            <td><span class="badge badge-status-<?php echo e($denuncia->status); ?>"><?php echo e(ucfirst($denuncia->status)); ?></span></td>
                            <td><span class="badge bg-<?php echo e(getPrioridadeColor($denuncia->prioridade)); ?>"><?php echo e(ucfirst($denuncia->prioridade)); ?></span></td>
                            <td><?php echo e($denuncia->localizacao ?? 'N/A'); ?></td>
                            <td><?php echo e($denuncia->created_at->format('d/m/Y')); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="btn btn-sm btn-outline-primary">Ver</a>
                                <form action="<?php echo e(route('denuncias.destroy', $denuncia)); ?>" method="POST" class="d-inline ms-1" onsubmit="return confirm('Tem certeza que deseja eliminar esta denúncia?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Nenhuma denúncia encontrada.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($denuncias->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/admin/denuncias/index.blade.php ENDPATH**/ ?>