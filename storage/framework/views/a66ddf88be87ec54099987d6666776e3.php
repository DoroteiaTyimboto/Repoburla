<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Sistema de Combate a Burlas Digitais'); ?></title>
    <script>
        (() => {
            const storedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = storedTheme || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --body-bg: #f8f9fa;
            --body-color: #333333;
            --surface-bg: #ffffff;
            --surface-muted: #f1f4f7;
            --border-color: rgba(44, 62, 80, 0.14);
            --shadow-color: rgba(15, 23, 42, 0.10);
            --muted-color: #6c757d;
            --footer-bg: var(--primary-color);
            --footer-text: rgba(255, 255, 255, 0.78);
            --dropdown-bg: #ffffff;
            --dropdown-link: #23303d;
        }

        [data-theme="dark"] {
            --primary-color: #0f172a;
            --secondary-color: #38bdf8;
            --body-bg: #06111f;
            --body-color: #e5eef8;
            --surface-bg: #0f1c2e;
            --surface-muted: #13243a;
            --border-color: rgba(148, 163, 184, 0.18);
            --shadow-color: rgba(2, 6, 23, 0.45);
            --muted-color: #9fb0c3;
            --footer-bg: #081120;
            --footer-text: rgba(226, 232, 240, 0.78);
            --dropdown-bg: #102033;
            --dropdown-link: #e5eef8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--body-bg);
            color: var(--body-color);
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 8px var(--shadow-color);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-brand i {
            font-size: 1.6rem;
        }

        main {
            min-height: calc(100vh - 140px);
            padding-top: 2rem;
            padding-bottom: 3rem;
        }

        footer {
            background: var(--footer-bg);
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
            border-top: 3px solid var(--secondary-color);
        }

        a {
            color: var(--secondary-color);
        }

        .text-muted {
            color: var(--muted-color) !important;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .badge-status-pendente {
            background-color: var(--warning-color);
        }

        .badge-status-aprovado {
            background-color: var(--secondary-color);
        }

        .badge-status-resolvido {
            background-color: var(--success-color);
        }

        .badge-status-rejeitado {
            background-color: var(--danger-color);
        }

        .card {
            border: 1px solid var(--border-color);
            background-color: var(--surface-bg);
            color: var(--body-color);
            box-shadow: 0 2px 8px var(--shadow-color);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px var(--shadow-color);
        }

        .page-title {
            color: var(--primary-color);
            margin-bottom: 2rem;
            border-bottom: 3px solid var(--secondary-color);
            padding-bottom: 1rem;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .table,
        .list-group-item,
        .form-control,
        .form-select,
        .modal-content,
        .dropdown-menu,
        .accordion-item,
        .pagination .page-link {
            background-color: var(--surface-bg);
            color: var(--body-color);
            border-color: var(--border-color);
        }

        .list-group-item-action:hover,
        .list-group-item-action:focus,
        .table-hover tbody tr:hover,
        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: var(--surface-muted);
            color: var(--body-color);
        }

        .dropdown-menu {
            background-color: var(--dropdown-bg);
        }

        .dropdown-item {
            color: var(--dropdown-link);
        }

        .dropdown-divider,
        hr {
            border-color: var(--border-color);
        }

        .form-control::placeholder {
            color: var(--muted-color);
        }

        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-light {
            color: var(--body-color);
            border-color: var(--border-color);
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover,
        .btn-outline-light:hover {
            color: #ffffff;
        }

        .theme-toggle {
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
        }

        .theme-toggle:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        [data-theme="dark"] .alert-success {
            background-color: rgba(39, 174, 96, 0.15);
            color: #9fe3b7;
        }

        [data-theme="dark"] .alert-danger {
            background-color: rgba(231, 76, 60, 0.14);
            color: #ffb4ab;
        }

        [data-theme="dark"] .alert-warning {
            background-color: rgba(243, 156, 18, 0.16);
            color: #ffd98a;
        }

        [data-theme="dark"] .alert-info {
            background-color: rgba(52, 152, 219, 0.14);
            color: #9edcff;
        }

        [data-theme="dark"] .btn-close {
            filter: invert(1);
        }

        @media (max-width: 768px) {
            main {
                padding-top: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="container">
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erros encontrados:</strong>
                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i><?php echo e(session('info')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make('components.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (() => {
            const root = document.documentElement;
            const setTheme = (theme) => {
                root.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);

                document.querySelectorAll('[data-theme-toggle-icon]').forEach((icon) => {
                    icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
                });

                document.querySelectorAll('[data-theme-toggle-label]').forEach((label) => {
                    label.textContent = theme === 'dark' ? 'Modo claro' : 'Modo escuro';
                });
            };

            document.addEventListener('click', (event) => {
                const button = event.target.closest('[data-theme-toggle]');

                if (!button) {
                    return;
                }

                const nextTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
                setTheme(nextTheme);
            });

            setTheme(root.getAttribute('data-theme') || 'light');
        })();
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/mac/Herd/Fraude/resources/views/layouts/app.blade.php ENDPATH**/ ?>