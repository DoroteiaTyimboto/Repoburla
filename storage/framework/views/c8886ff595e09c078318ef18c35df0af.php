<?php $__env->startSection('title', 'Detalhes do Teste'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Detalhes do Teste</h1>
        <a href="<?php echo e(route('testador.index')); ?>" class="btn btn-outline-primary">Voltar</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h5 class="mb-3"><?php echo e($testador->url_testada); ?></h5>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-<?php echo e($testador->getRiscoColor()); ?>"><?php echo e(ucfirst($testador->classificacao_risco)); ?></span>
                        <span class="badge bg-secondary"><?php echo e($testador->tempo_verificacao); ?>ms</span>
                        <span class="badge bg-info text-dark"><?php echo e($testador->reputacao_dominio ?? 'desconhecido'); ?></span>
                    </div>
                    <div class="small text-muted">
                        Testado em <?php echo e($testador->created_at->format('d/m/Y H:i:s')); ?>

                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <form action="<?php echo e(route('testador.delete', $testador)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-outline-danger">Excluir do histórico</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Resultado</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Status HTTP</dt>
                        <dd class="col-sm-7"><?php echo e($testador->resultado['status_code'] ?? 'N/A'); ?></dd>

                        <dt class="col-sm-5">Mensagem</dt>
                        <dd class="col-sm-7"><?php echo e($testador->resultado['status_texto'] ?? 'N/A'); ?></dd>

                        <dt class="col-sm-5">IP de destino</dt>
                        <dd class="col-sm-7"><?php echo e($testador->ip_destino ?? 'Não identificado'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">SSL</h5>
                </div>
                <div class="card-body">
                    <?php if($testador->certificado_ssl): ?>
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Válido</dt>
                            <dd class="col-sm-7"><?php echo e(($testador->certificado_ssl['valido'] ?? false) ? 'Sim' : 'Não'); ?></dd>

                            <dt class="col-sm-5">Válido até</dt>
                            <dd class="col-sm-7"><?php echo e($testador->certificado_ssl['valido_ate'] ?? 'N/A'); ?></dd>

                            <dt class="col-sm-5">Emitido por</dt>
                            <dd class="col-sm-7"><?php echo e($testador->certificado_ssl['emitido_por'] ?? 'N/A'); ?></dd>
                        </dl>
                    <?php else: ?>
                        <p class="text-muted mb-0">Nenhuma informação SSL disponível para este link.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detalhes Técnicos</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Content-Type</dt>
                <dd class="col-sm-9"><?php echo e($testador->detalhes_verificacao['content_type'] ?? 'N/A'); ?></dd>

                <dt class="col-sm-3">Servidor</dt>
                <dd class="col-sm-9"><?php echo e($testador->detalhes_verificacao['server'] ?? 'N/A'); ?></dd>

                <dt class="col-sm-3">Redirecionamentos</dt>
                <dd class="col-sm-9">
                    <?php echo e(($testador->detalhes_verificacao['redirects_detectados'] ?? false) ? 'Detectados' : 'Não detectados'); ?>

                </dd>

                <?php if(isset($testador->detalhes_verificacao['erro'])): ?>
                    <dt class="col-sm-3">Erro</dt>
                    <dd class="col-sm-9 text-danger"><?php echo e($testador->detalhes_verificacao['erro']); ?></dd>
                <?php endif; ?>
            </dl>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/testador/show.blade.php ENDPATH**/ ?>