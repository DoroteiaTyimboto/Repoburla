<?php $__env->startSection('title', $curso->titulo); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="page-title"><?php echo e($curso->titulo); ?></h1>

            <div class="card mb-4">
                <?php if($curso->imagem_capa): ?>
                    <img src="<?php echo e($curso->imagem_capa); ?>" class="card-img-top" alt="<?php echo e($curso->titulo); ?>" style="height: 300px; object-fit: cover;">
                <?php else: ?>
                    <div style="height: 300px; background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); display: flex; align-items: center; justify-content: center; color: white;">
                        <i class="bi bi-book" style="font-size: 5rem;"></i>
                    </div>
                <?php endif; ?>

                <div class="card-body">
                    <h5 class="card-title">Sobre o Curso</h5>
                    <p class="card-text"><?php echo e($curso->descricao); ?></p>

                    <div class="mb-3">
                        <span class="badge bg-info"><?php echo e(ucfirst($curso->nivel)); ?></span>
                        <?php if($curso->duracao_minutos): ?>
                            <span class="badge bg-secondary"><i class="bi bi-clock"></i> <?php echo e($curso->duracao_minutos); ?> minutos</span>
                        <?php endif; ?>
                        <?php if($curso->categoria): ?>
                            <span class="badge bg-primary"><?php echo e($curso->categoria); ?></span>
                        <?php endif; ?>
                    </div>

                    <hr>

                    <h5 class="mb-3">Estatísticas</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold"><?php echo e($totalInscritos); ?></h3>
                                <small class="text-muted">Inscritos</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold"><?php echo e($totalConcluido); ?></h3>
                                <small class="text-muted">Concluído</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold"><?php echo e($taxaConclusao); ?>%</h3>
                                <small class="text-muted">Taxa</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold"><?php echo e($mediaAvaliacoes); ?>/5</h3>
                                <small class="text-muted">Avaliação</small>
                            </div>
                        </div>
                    </div>

                    <?php if($curso->conteudo): ?>
                        <hr>
                        <h5>Conteúdo</h5>
                        <div class="alert alert-light">
                            <?php echo nl2br(e($curso->conteudo)); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Avaliações -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Avaliações</h5>
                </div>
                <div class="card-body">
                    <?php if(auth()->check() && $isInscrito): ?>
                        <form action="<?php echo e(route('cursos.rate', $curso)); ?>" method="POST" class="mb-4">
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
                    <?php if(auth()->check() && $isInscrito): ?>
                        <form action="<?php echo e(route('cursos.comment', $curso)); ?>" method="POST" class="mb-4">
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
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <?php if($isInscrito): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> Você está inscrito neste curso
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seu Progresso</label>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                            </div>
                        </div>

                        <form action="<?php echo e(route('cursos.unenroll', $curso)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle"></i> Desinscrever
                            </button>
                        </form>
                    <?php else: ?>
                        <?php if(auth()->guard()->check()): ?>
                            <form action="<?php echo e(route('cursos.enroll', $curso)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="bi bi-plus-circle"></i> Inscrever-se
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-login"></i> Login para Inscrever
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <hr>

                    <h6>Informações</h6>
                    <dl class="small mb-0">
                        <dt>Nível</dt>
                        <dd><?php echo e(ucfirst($curso->nivel)); ?></dd>

                        <dt>Duração</dt>
                        <dd><?php echo e($curso->duracao_minutos ?? 'Sem limite'); ?> minutos</dd>

                        <dt>Categoria</dt>
                        <dd><?php echo e($curso->categoria ?? 'Geral'); ?></dd>

                        <dt>Inscritos</dt>
                        <dd><?php echo e($totalInscritos); ?></dd>

                        <dt>Avaliação</dt>
                        <dd>
                            <?php if($mediaAvaliacoes > 0): ?>
                                <i class="bi bi-star-fill" style="color: #f39c12;"></i> <?php echo e($mediaAvaliacoes); ?>/5
                            <?php else: ?>
                                Sem avaliações
                            <?php endif; ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/cursos/show.blade.php ENDPATH**/ ?>