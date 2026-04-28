<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h1 class="page-title">Dashboard - Bem-vindo, <?php echo e($user->name); ?>!</h1>

    <!-- Notificações não lidas -->
    <?php if($notificacoes->count() > 0): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-bell"></i> Você tem <?php echo e($notificacoes->count()); ?> notificações não lidas</strong>
            <?php $__currentLoopData = $notificacoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="small mt-2">• <?php echo e($notif->titulo); ?>: <?php echo e($notif->mensagem); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats do usuário -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center metric-card" data-tone="danger">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle metric-icon text-danger"></i>
                    <h6 class="mt-2">Minhas Denúncias</h6>
                    <h3 class="fw-bold"><?php echo e($meusRelatorios['total']); ?></h3>
                    <small class="text-muted">
                        Pendentes: <?php echo e($meusRelatorios['pendente']); ?> | 
                        Aprovadas: <?php echo e($meusRelatorios['aprovado']); ?>

                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center metric-card" data-tone="success">
                <div class="card-body">
                    <i class="bi bi-book metric-icon text-success"></i>
                    <h6 class="mt-2">Meus Cursos</h6>
                    <h3 class="fw-bold"><?php echo e($cursosDados['total']); ?></h3>
                    <small class="text-muted">
                        Em progresso: <?php echo e($cursosDados['emProgresso']); ?> | 
                        Concluídos: <?php echo e($cursosDados['concluido']); ?>

                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center metric-card" data-tone="warning">
                <div class="card-body">
                    <i class="bi bi-link metric-icon text-warning"></i>
                    <h6 class="mt-2">Ações Rápidas</h6>
                    <div class="mt-2">
                        <a href="<?php echo e(route('testador.index')); ?>" class="btn btn-sm btn-warning">Testador</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin section -->
    <?php if($user->isModerator()): ?>
        <h3 class="page-title mt-5">Painel Administrativo</h3>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Denúncias Pendentes</h6>
                        <h2 class="fw-bold text-danger"><?php echo e($sistemaDados['denunciasPendentes']); ?></h2>
                        <a href="<?php echo e(route('admin.denuncias')); ?>" class="btn btn-sm btn-outline-danger">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total de Usuários</h6>
                        <h2 class="fw-bold text-info"><?php echo e($sistemaDados['totalUsuarios']); ?></h2>
                        <a href="<?php echo e(route('admin.usuarios')); ?>" class="btn btn-sm btn-outline-info">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Cursos Publicados</h6>
                        <h2 class="fw-bold text-success"><?php echo e($sistemaDados['cursosPublicados']); ?></h2>
                        <a href="<?php echo e(route('admin.cursos')); ?>" class="btn btn-sm btn-outline-success">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Testador de Links</h6>
                        <h2 class="fw-bold text-warning"><?php echo e($sistemaDados['totalUsuarios'] ?? 0); ?></h2>
                        <a href="<?php echo e(route('testador.index')); ?>" class="btn btn-sm btn-outline-warning">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Quick Links -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="page-title">Atalhos</h3>
            <div class="d-grid gap-2 d-sm-flex">
                <a href="<?php echo e(route('denuncias.create')); ?>" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Reportar Fraude
                </a>
                <a href="<?php echo e(route('cursos.index')); ?>" class="btn btn-success">
                    <i class="bi bi-book"></i> Ver Cursos
                </a>
                <a href="<?php echo e(route('testador.index')); ?>" class="btn btn-warning">
                    <i class="bi bi-link"></i> Testar Link
                </a>
                <a href="<?php echo e(route('profile')); ?>" class="btn btn-secondary">
                    <i class="bi bi-person"></i> Meu Perfil
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/mac/Herd/Fraude/resources/views/dashboard.blade.php ENDPATH**/ ?>