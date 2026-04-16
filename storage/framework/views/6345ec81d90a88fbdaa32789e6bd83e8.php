<?php $__env->startSection('title', $denuncia->titulo); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="page-title"><?php echo e($denuncia->titulo); ?></h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge badge-status-<?php echo e($denuncia->status); ?> me-2">
                                <?php echo e(ucfirst($denuncia->status)); ?>

                            </span>
                            <span class="badge bg-<?php echo e(getPrioridadeColor($denuncia->prioridade)); ?>">
                                <?php echo e(ucfirst($denuncia->prioridade)); ?>

                            </span>
                        </div>
                        <?php if(auth()->check() && (auth()->id() === $denuncia->user_id || auth()->user()->isModerator()) && $denuncia->status === 'pendente'): ?>
                            <a href="<?php echo e(route('denuncias.edit', $denuncia)); ?>" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Reportado por</small>
                            <strong><?php echo e($denuncia->user->name); ?></strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Data</small>
                            <strong><?php echo e($denuncia->created_at->format('d/m/Y H:i')); ?></strong>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Descrição</h5>
                    <p class="lead"><?php echo e($denuncia->descricao); ?></p>

                    <?php if($denuncia->tipo): ?>
                        <p><strong>Tipo:</strong> <?php echo e(ucfirst($denuncia->tipo)); ?></p>
                    <?php endif; ?>

                    <?php if($denuncia->url_suspeita): ?>
                        <p><strong>URL Suspeita:</strong> <code><?php echo e($denuncia->url_suspeita); ?></code></p>
                    <?php endif; ?>

                    <?php if($denuncia->localizacao): ?>
                        <p><strong>Localização:</strong> <?php echo e($denuncia->localizacao); ?></p>
                    <?php endif; ?>

                    <?php if($denuncia->data_incidente): ?>
                        <p><strong>Data do Incidente:</strong> <?php echo e($denuncia->data_incidente->format('d/m/Y')); ?></p>
                    <?php endif; ?>

                    <?php if($denuncia->resultado_verificacao && is_array($denuncia->resultado_verificacao) && !empty($denuncia->resultado_verificacao)): ?>
                        <hr>
                        <h5>Resultado da Verificação</h5>
                        <div class="alert alert-info">
                            <?php $__currentLoopData = $denuncia->resultado_verificacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <strong><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?>:</strong> <?php echo e($value); ?><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Avaliações -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Avaliações 
                        <?php if($mediaAvaliacoes > 0): ?>
                            <span class="badge bg-warning ms-2"><?php echo e($mediaAvaliacoes); ?>/5</span>
                        <?php endif; ?>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if(auth()->guard()->check()): ?>
                        <form action="<?php echo e(route('denuncias.rate', $denuncia)); ?>" method="POST" class="mb-4">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label">Sua Avaliação</label>
                                <div class="btn-group" role="group">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <input type="radio" class="btn-check" name="classificacao" id="btn<?php echo e($i); ?>" value="<?php echo e($i); ?>">
                                        <label class="btn btn-outline-warning" for="btn<?php echo e($i); ?>">
                                            <i class="bi bi-star-fill"></i> <?php echo e($i); ?>

                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Avaliar</button>
                        </form>
                    <?php endif; ?>

                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $avaliacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avaliacao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong><?php echo e($avaliacao->user->name); ?></strong>
                                        <div class="text-warning">
                                            <?php for($i = 0; $i < $avaliacao->classificacao; $i++): ?>
                                                <i class="bi bi-star-fill"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <small class="text-muted"><?php echo e($avaliacao->created_at->format('d/m/Y')); ?></small>
                                </div>
                                <?php if($avaliacao->comentario): ?>
                                    <p class="small text-muted mt-2 mb-0"><?php echo e($avaliacao->comentario); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted text-center py-4">Nenhuma avaliação ainda</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Comentários -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Comentários (<?php echo e($comentarios->total()); ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if(auth()->guard()->check()): ?>
                        <form action="<?php echo e(route('denuncias.comment', $denuncia)); ?>" method="POST" class="mb-4">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <textarea name="conteudo" class="form-control" rows="3" placeholder="Adicionar comentário..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Comentar</button>
                        </form>
                    <?php endif; ?>

                    <div class="list-group">
                        <?php $__empty_1 = true; $__currentLoopData = $comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong><?php echo e($comentario->user->name); ?></strong>
                                    <small class="text-muted"><?php echo e($comentario->created_at->format('d/m/Y H:i')); ?></small>
                                </div>
                                <p class="small text-muted mt-2 mb-0"><?php echo e($comentario->conteudo); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-muted text-center py-4">Nenhum comentário ainda</div>
                        <?php endif; ?>
                    </div>

                    <?php if($comentarios->hasPages()): ?>
                        <div class="mt-3">
                            <?php echo e($comentarios->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informações laterais -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="card-title">Informações</h6>
                    <dl class="row">
                        <dt class="col-sm-6">Tipo:</dt>
                        <dd class="col-sm-6"><span class="badge bg-secondary"><?php echo e(ucfirst($denuncia->tipo)); ?></span></dd>

                        <dt class="col-sm-6">Status:</dt>
                        <dd class="col-sm-6"><span class="badge badge-status-<?php echo e($denuncia->status); ?>"><?php echo e(ucfirst($denuncia->status)); ?></span></dd>

                        <dt class="col-sm-6">Prioridade:</dt>
                        <dd class="col-sm-6"><span class="badge bg-<?php echo e(getPrioridadeColor($denuncia->prioridade)); ?>"><?php echo e(ucfirst($denuncia->prioridade)); ?></span></dd>

                        <dt class="col-sm-6">Comentários:</dt>
                        <dd class="col-sm-6"><?php echo e($comentarios->total()); ?></dd>

                        <dt class="col-sm-6">Avaliações:</dt>
                        <dd class="col-sm-6"><?php echo e($avaliacoes->count()); ?></dd>
                    </dl>

                    <?php if(auth()->check() && (auth()->user()->isModerator() || auth()->id() === $denuncia->user_id)): ?>
                        <hr>
                        <h6>Ações</h6>
                        <div class="d-grid gap-2">
                            <?php if(auth()->user()->isModerator() && $denuncia->status === 'pendente'): ?>
                                <form action="<?php echo e(route('denuncias.approve', $denuncia)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-success w-100">
                                        <i class="bi bi-check-circle"></i> Aprovar
                                    </button>
                                </form>

                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="bi bi-x-circle"></i> Rejeitar
                                </button>
                            <?php endif; ?>

                            <?php if($denuncia->status === 'aprovado'): ?>
                                <?php if((auth()->user()->isModerator() || auth()->id() === $denuncia->user_id) && ($denuncia->resultado_verificacao['reportado_autoridades'] ?? null) !== 'Sim'): ?>
                                    <form action="<?php echo e(route('denuncias.report-authorities', $denuncia)); ?>" method="POST" onsubmit="return confirm('Confirmar envio desta denúncia para as autoridades?');">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-warning w-100">
                                            <i class="bi bi-megaphone"></i> Reportar às Autoridades
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-success mb-0 py-2 small">
                                        <i class="bi bi-check-circle"></i> Já reportada às autoridades
                                    </div>
                                <?php endif; ?>

                                <?php if(auth()->user()->isModerator()): ?>
                                    <form action="<?php echo e(route('denuncias.resolve', $denuncia)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-sm btn-success w-100">
                                            <i class="bi bi-check2-all"></i> Marcar Resolvido
                                        </button>
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<?php if(auth()->user()?->isModerator()): ?>
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rejeitar Denúncia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="<?php echo e(route('denuncias.reject', $denuncia)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Motivo da Rejeição</label>
                            <textarea name="motivo" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Rejeitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/denuncias/show.blade.php ENDPATH**/ ?>