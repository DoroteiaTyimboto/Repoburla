<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
            <i class="bi bi-shield-check"></i>
            <span>Burlas Digitais</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center me-lg-2 mb-2 mb-lg-0">
                    <button type="button" class="btn btn-sm theme-toggle" data-theme-toggle>
                        <i class="bi bi-moon-stars-fill" data-theme-toggle-icon></i>
                        <span class="ms-2 d-none d-md-inline" data-theme-toggle-label>Modo escuro</span>
                    </button>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('denuncias.index')); ?>">Denúncias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('cursos.index')); ?>">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('testador.index')); ?>">Testador de Links</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('mapa')); ?>">Mapa</a>
                </li>

                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?php echo e(auth()->user()->name); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profile')); ?>">Perfil</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('my-denuncias')); ?>">Minhas Denúncias</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('my-cursos')); ?>">Meus Cursos</a></li>

                            <?php if(auth()->user()->isModerator()): ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">Admin</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.denuncias')); ?>">Gerenciar Denúncias</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.usuarios')); ?>">Gerenciar Usuários</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.cursos')); ?>">Gerenciar Cursos</a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('admin.relatorios')); ?>">Relatórios</a></li>
                            <?php endif; ?>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-primary ms-2" href="<?php echo e(route('register')); ?>">Registrar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /Users/mac/Herd/Fraude/resources/views/components/navbar.blade.php ENDPATH**/ ?>