<?php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;
?>

<?php $__env->startSection('title', 'Início - Sistema de Combate a Burlas Digitais'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5" style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); border-radius: 12px; padding: 4rem 2rem; color: white;">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-3">Proteja-se Contra Burlas Digitais</h1>
            <p class="lead mb-4">Sistema completo para identificar, reportar e combater fraudes online com educação contínua e ferramentas avançadas.</p>
            <div class="d-flex gap-3">
                <a href="<?php echo e(route('denuncias.index')); ?>" class="btn btn-light btn-lg">
                    <i class="bi bi-flag"></i> Ver Denúncias
                </a>
                <a href="<?php echo e(route('cursos.index')); ?>" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-book"></i> Cursos
                </a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <i class="bi bi-shield-check" style="font-size: 120px; opacity: 0.8;"></i>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-5 justify-content-center">
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="border-top: 4px solid #e74c3c;">
                <div class="card-body">
                    <h5 class="card-title">Denúncias Reportadas</h5>
                    <h2 class="fw-bold" style="color: #e74c3c;"><?php echo e($stats['totalDenuncias']); ?></h2>
                    <p class="text-muted">Resolvidas: <?php echo e($stats['denunciasResolvidas']); ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="border-top: 4px solid #27ae60;">
                <div class="card-body">
                    <h5 class="card-title">Cursos Disponíveis</h5>
                    <h2 class="fw-bold" style="color: #27ae60;"><?php echo e($stats['cursosDisponivel']); ?></h2>
                    <p class="text-muted">Educação Contínua</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card text-center" style="border-top: 4px solid #f39c12;">
                <div class="card-body">
                    <h5 class="card-title">Links Testados</h5>
                    <h2 class="fw-bold" style="color: #f39c12;"><?php echo e($stats['linksTestados']); ?></h2>
                    <p class="text-muted">Verificações de Segurança</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos em Destaque -->
    <h2 class="page-title">Cursos em Destaque</h2>
    <div class="row mb-5">
        <?php $__empty_1 = true; $__currentLoopData = $cursosDestaque; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $curso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($curso->titulo); ?></h5>
                        <p class="card-text text-muted"><?php echo e(\Illuminate\Support\Str::limit($curso->descricao, 100)); ?></p>
                        <div class="mb-3">
                            <span class="badge bg-info"><?php echo e(ucfirst($curso->nivel)); ?></span>
                            <?php if($curso->duracao_minutos): ?>
                                <span class="badge bg-secondary"><?php echo e($curso->duracao_minutos); ?> min</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo e(route('cursos.show', $curso)); ?>" class="btn btn-sm btn-primary">
                            Ver Curso <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">Nenhum curso disponível no momento.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Últimas Denúncias -->
    <h2 class="page-title">Últimas Denúncias</h2>
    <div class="row mb-5">
        <?php $__empty_1 = true; $__currentLoopData = $ultimasDenuncias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $denuncia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title"><?php echo e($denuncia->titulo); ?></h5>
                            <span class="badge badge-status-<?php echo e($denuncia->status); ?>"><?php echo e(ucfirst($denuncia->status)); ?></span>
                        </div>
                        <p class="card-text text-muted"><?php echo e(\Illuminate\Support\Str::limit($denuncia->descricao, 120)); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-person"></i> <?php echo e($denuncia->user->name); ?> | 
                                <i class="bi bi-calendar"></i> <?php echo e($denuncia->created_at->format('d/m/Y')); ?>

                            </small>
                            <a href="<?php echo e(route('denuncias.show', $denuncia)); ?>" class="btn btn-sm btn-outline-primary">
                                Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="alert alert-info">Nenhuma denúncia disponível no momento.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- CTA Section -->
    <div class="row mt-5 mb-5" style="background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); border-radius: 12px; padding: 3rem 2rem; color: white; text-align: center;">
        <div class="col-12">
            <h2 class="mb-3">Teste Links Suspeitos</h2>
            <p class="lead mb-4">Use nosso testador de links para verificar a segurança de URLs antes de acessá-las</p>
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('testador.index')); ?>" class="btn btn-light btn-lg">
                    <i class="bi bi-link"></i> Acessar Testador
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-light btn-lg">
                    <i class="bi bi-link"></i> Login para Testar
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/home.blade.php ENDPATH**/ ?>