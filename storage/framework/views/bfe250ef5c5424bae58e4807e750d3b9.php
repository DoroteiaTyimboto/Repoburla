<?php $__env->startSection('title', 'Cursos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="page-title">Cursos de Segurança Digital</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <form action="<?php echo e(route('cursos.filter')); ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar cursos..." value="<?php echo e(request('busca')); ?>">
                </div>
                <div class="col-md-3">
                    <select name="categoria" class="form-select">
                        <option value="">Todas as categorias</option>
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat); ?>" <?php echo e(request('categoria') === $cat ? 'selected' : ''); ?>><?php echo e($cat); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="nivel" class="form-select">
                        <option value="">Todos os níveis</option>
                        <option value="iniciante">Iniciante</option>
                        <option value="intermediario">Intermediário</option>
                        <option value="avancado">Avançado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $cursos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if($curso->imagem_capa): ?>
                        <img src="<?php echo e($curso->imagem_capa); ?>" class="card-img-top" alt="<?php echo e($curso->titulo); ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div style="height: 200px; background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="bi bi-book" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo e($curso->titulo); ?></h5>
                        <p class="card-text text-muted flex-grow-1"><?php echo e(\Illuminate\Support\Str::limit($curso->descricao, 100)); ?></p>

                        <div class="mb-3">
                            <span class="badge bg-info"><?php echo e(ucfirst($curso->nivel)); ?></span>
                            <?php if($curso->duracao_minutos): ?>
                                <span class="badge bg-secondary"><?php echo e($curso->duracao_minutos); ?> min</span>
                            <?php endif; ?>
                            <?php if($curso->categoria): ?>
                                <span class="badge bg-primary"><?php echo e($curso->categoria); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="small text-muted mb-3">
                            <i class="bi bi-people"></i> <?php echo e($curso->getTotalInscritos()); ?> inscritos | 
                            <i class="bi bi-percent"></i> <?php echo e($curso->getTaxaConclusao()); ?>% concluído
                        </div>

                        <?php if($curso->getMediaAvaliacoes() > 0): ?>
                            <div class="mb-3">
                                <i class="bi bi-star-fill" style="color: #f39c12;"></i>
                                <?php echo e($curso->getMediaAvaliacoes()); ?>/5 (<?php echo e($curso->avaliacoes()->count()); ?> avaliações)
                            </div>
                        <?php endif; ?>

                        <a href="<?php echo e(route('cursos.show', $curso)); ?>" class="btn btn-primary mt-auto">
                            <i class="bi bi-arrow-right"></i> Ver Curso
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Nenhum curso encontrado.
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Anúncios sobre Segurança da Internet -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="page-title">Dicas de Segurança na Internet</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-lock-fill text-info me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Use Senhas Fortes</h5>
                    </div>
                    <p class="card-text">Crie senhas com pelo menos 12 caracteres, combinando letras maiúsculas, minúsculas, números e símbolos. Evite usar informações pessoais óbvias.</p>
                    <a href="#" class="btn btn-outline-info">Saiba Mais</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-eye-slash-fill text-warning me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Verifique Antes de Clicar</h5>
                    </div>
                    <p class="card-text">Sempre verifique a URL antes de clicar em links suspeitos. Use nosso testador de links para analisar endereços duvidosos.</p>
                    <a href="<?php echo e(route('testador.index')); ?>" class="btn btn-outline-warning">Testar Link</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-shield-check-fill text-success me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Atualize seus Dispositivos</h5>
                    </div>
                    <p class="card-text">Mantenha seu sistema operacional, navegadores e aplicativos sempre atualizados para corrigir vulnerabilidades de segurança.</p>
                    <a href="#" class="btn btn-outline-success">Dicas de Atualização</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Não Compartilhe Dados Sensíveis</h5>
                    </div>
                    <p class="card-text">Evite compartilhar informações pessoais, bancárias ou senhas em sites não confiáveis ou por email suspeito.</p>
                    <a href="<?php echo e(route('denuncias.create')); ?>" class="btn btn-outline-danger">Reportar Fraude</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <?php echo e($cursos->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/cursos/index.blade.php ENDPATH**/ ?>