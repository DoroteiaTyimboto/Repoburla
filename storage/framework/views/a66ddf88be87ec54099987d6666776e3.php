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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #123a5c;
            --secondary-color: #0ea5e9;
            --success-color: #15803d;
            --danger-color: #dc2626;
            --warning-color: #d97706;
            --body-bg: #f3f7fb;
            --body-color: #0f172a;
            --surface-bg: #ffffff;
            --surface-muted: #eef4fa;
            --border-color: rgba(17, 24, 39, 0.1);
            --shadow-color: rgba(15, 23, 42, 0.12);
            --muted-color: #475569;
            --footer-bg: #0f2e48;
            --footer-text: rgba(241, 245, 249, 0.85);
            --dropdown-bg: #ffffff;
            --dropdown-link: #1e293b;
            --radius-lg: 18px;
            --radius-md: 14px;
        }

        [data-theme="dark"] {
            --primary-color: #0b2238;
            --secondary-color: #38bdf8;
            --body-bg: #08111d;
            --body-color: #e2e8f0;
            --surface-bg: #0f1b2b;
            --surface-muted: #142338;
            --border-color: rgba(148, 163, 184, 0.2);
            --shadow-color: rgba(2, 6, 23, 0.45);
            --muted-color: #a7b7ca;
            --footer-bg: #07121f;
            --footer-text: rgba(226, 232, 240, 0.82);
            --dropdown-bg: #102033;
            --dropdown-link: #e5eef8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background-color: var(--body-bg);
            color: var(--body-color);
            transition: background-color 0.25s ease, color 0.25s ease;
            background-image:
                radial-gradient(circle at 10% 0%, rgba(14, 165, 233, 0.08), transparent 45%),
                radial-gradient(circle at 90% 90%, rgba(18, 58, 92, 0.08), transparent 35%);
        }

        .navbar {
            background: linear-gradient(120deg, rgba(10, 37, 62, 0.95) 0%, rgba(14, 165, 233, 0.9) 100%);
            box-shadow: 0 12px 26px rgba(2, 6, 23, 0.2);
            backdrop-filter: blur(8px);
        }

        .navbar-brand {
            font-family: 'Sora', sans-serif;
            font-weight: 700;
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
            padding-top: 2.2rem;
            padding-bottom: 3rem;
            max-width: 1180px;
        }

        footer {
            background: var(--footer-bg);
            color: white;
            padding: 2.5rem 0;
            margin-top: 4rem;
            border-top: 1px solid rgba(148, 163, 184, 0.25);
        }

        a {
            color: var(--secondary-color);
            text-decoration-thickness: 2px;
            text-underline-offset: 3px;
        }

        .text-muted {
            color: var(--muted-color) !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Sora', sans-serif;
            letter-spacing: -0.02em;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            border-radius: 999px;
            font-weight: 700;
            letter-spacing: 0.01em;
            padding: 0.55rem 1.1rem;
        }

        .btn-primary:hover {
            background-color: #0284c7;
            border-color: #0284c7;
            transform: translateY(-1px);
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
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 26px var(--shadow-color);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.16);
        }

        .page-title {
            color: var(--primary-color);
            margin-bottom: 2rem;
            border-bottom: 2px solid rgba(14, 165, 233, 0.35);
            padding-bottom: 0.8rem;
            font-size: clamp(1.45rem, 2vw, 1.9rem);
        }

        .alert {
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
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
            border-radius: var(--radius-md);
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

        .form-control,
        .form-select {
            padding: 0.65rem 0.85rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(14, 165, 233, 0.65);
            box-shadow: 0 0 0 0.2rem rgba(14, 165, 233, 0.15);
        }

        .btn-outline-primary,
        .btn-outline-secondary,
        .btn-outline-light {
            color: var(--body-color);
            border-color: var(--border-color);
            border-radius: 999px;
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
            border-radius: 999px;
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

        .hero-panel {
            background: linear-gradient(135deg, #0f2e48 0%, #0ea5e9 120%);
            border-radius: 26px;
            padding: clamp(2rem, 4vw, 3.6rem);
            color: #ffffff;
            box-shadow: 0 20px 45px rgba(2, 6, 23, 0.25);
        }

        .cta-panel {
            background: linear-gradient(130deg, #0284c7 0%, #0f2e48 100%);
            border-radius: 22px;
            padding: clamp(2rem, 4vw, 3rem);
            color: #ffffff;
            text-align: center;
        }

        .metric-card {
            border-top-width: 4px;
            border-top-style: solid;
        }

        .metric-card[data-tone="danger"] { border-top-color: #dc2626; }
        .metric-card[data-tone="success"] { border-top-color: #16a34a; }
        .metric-card[data-tone="warning"] { border-top-color: #d97706; }
        .metric-card[data-tone="info"] { border-top-color: #0284c7; }

        .metric-icon {
            font-size: 2rem;
            display: inline-block;
            margin-bottom: 0.4rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes softPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes driftGlow {
            0%, 100% { box-shadow: 0 20px 45px rgba(2, 6, 23, 0.25); }
            50% { box-shadow: 0 24px 56px rgba(2, 6, 23, 0.33); }
        }

        body.app-ready .page-title {
            animation: fadeInUp 0.45s ease both;
        }

        .hero-panel {
            animation: fadeInUp 0.55s ease both, driftGlow 5s ease-in-out infinite;
        }

        .cta-panel {
            animation: fadeInUp 0.55s ease both;
        }

        .card,
        .alert,
        .list-group-item {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity 0.5s ease, transform 0.5s ease;
            will-change: opacity, transform;
        }

        .is-revealed {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .badge-status-pendente {
            animation: softPulse 2s ease-in-out infinite;
        }

        .btn,
        .theme-toggle {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        .btn:hover,
        .theme-toggle:hover {
            transform: translateY(-1px);
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation: none !important;
                transition: none !important;
                scroll-behavior: auto !important;
            }

            .card,
            .alert,
            .list-group-item {
                opacity: 1 !important;
                transform: none !important;
            }
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
    <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
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
    <script>
        (() => {
            document.body.classList.add('app-ready');

            const reverbKey = <?php echo json_encode(env('REVERB_APP_KEY'), 15, 512) ?>;
            const reverbHost = <?php echo json_encode(env('REVERB_HOST', '127.0.0.1'), 512) ?>;
            const reverbPort = Number(<?php echo json_encode((int) env('REVERB_PORT', 8080), 512) ?>);
            const reverbScheme = <?php echo json_encode(env('REVERB_SCHEME', 'http'), 512) ?>;
            const notifSummaryUrl = <?php echo json_encode(auth()->check() ? route('notificacoes.summary') : null, 15, 512) ?>;
            let unsavedChanges = false;
            let lastUnreadCount = null;

            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!prefersReducedMotion && 'IntersectionObserver' in window) {
                const revealTargets = document.querySelectorAll('.card, .alert, .list-group-item, .hero-panel, .cta-panel');
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-revealed');
                            obs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });

                revealTargets.forEach((el, index) => {
                    el.style.transitionDelay = `${Math.min(index * 40, 260)}ms`;
                    observer.observe(el);
                });
            } else {
                document.querySelectorAll('.card, .alert, .list-group-item, .hero-panel, .cta-panel').forEach((el) => {
                    el.classList.add('is-revealed');
                });
            }

            const markUnsaved = () => {
                unsavedChanges = true;
            };

            document.querySelectorAll('form').forEach((form) => {
                form.addEventListener('input', markUnsaved);
                form.addEventListener('change', markUnsaved);
                form.addEventListener('submit', () => {
                    unsavedChanges = false;
                });
            });

            const showUpdateBanner = () => {
                if (document.getElementById('realtime-update-banner')) {
                    return;
                }

                const banner = document.createElement('div');
                banner.id = 'realtime-update-banner';
                banner.className = 'alert alert-info shadow';
                banner.style.position = 'fixed';
                banner.style.right = '16px';
                banner.style.bottom = '16px';
                banner.style.zIndex = '1080';
                banner.style.maxWidth = '420px';
                banner.innerHTML = `
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-arrow-clockwise mt-1"></i>
                        <div class="flex-grow-1">
                            <div class="fw-semibold">Há novas atualizações no sistema.</div>
                            <div class="small">Guarde o formulário e clique em atualizar.</div>
                        </div>
                        <button id="realtime-refresh-now" type="button" class="btn btn-sm btn-primary">Atualizar</button>
                    </div>
                `;

                document.body.appendChild(banner);
                document.getElementById('realtime-refresh-now')?.addEventListener('click', () => {
                    window.location.reload();
                });
            };

            const showToast = (title, message) => {
                const escapeHtml = (value) => String(value ?? '')
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');

                const containerId = 'app-toast-container';
                let container = document.getElementById(containerId);

                if (!container) {
                    container = document.createElement('div');
                    container.id = containerId;
                    container.className = 'toast-container position-fixed top-0 end-0 p-3';
                    container.style.zIndex = '1090';
                    document.body.appendChild(container);
                }

                const toastEl = document.createElement('div');
                toastEl.className = 'toast border-0 shadow-sm';
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');
                toastEl.innerHTML = `
                    <div class="toast-header">
                        <i class="bi bi-bell-fill me-2 text-primary"></i>
                        <strong class="me-auto">${escapeHtml(title || 'Nova notificação')}</strong>
                        <small>agora</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">${escapeHtml(message || '')}</div>
                `;

                container.appendChild(toastEl);
                const toast = new bootstrap.Toast(toastEl, { delay: 4500 });
                toast.show();
                toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            };

            const refreshNotificationBell = async () => {
                if (!notifSummaryUrl) {
                    return;
                }

                const response = await fetch(notifSummaryUrl, {
                    method: 'GET',
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });

                if (!response.ok) {
                    return;
                }

                const data = await response.json();
                const badge = document.getElementById('notif-count-badge');
                const list = document.getElementById('notif-list');
                const unread = Number(data.unread_count || 0);

                if (badge) {
                    badge.textContent = unread;
                    badge.classList.toggle('d-none', unread <= 0);
                }

                if (list && Array.isArray(data.items)) {
                    const escapeHtml = (value) => String(value ?? '')
                        .replaceAll('&', '&amp;')
                        .replaceAll('<', '&lt;')
                        .replaceAll('>', '&gt;')
                        .replaceAll('"', '&quot;')
                        .replaceAll("'", '&#039;');

                    if (data.items.length === 0) {
                        list.innerHTML = '<div class="px-3 py-3 text-muted small">Sem notificações no momento.</div>';
                    } else {
                        list.innerHTML = data.items.map((item) => `
                            <div class="px-3 py-2 border-bottom ${item.is_read ? '' : 'bg-opacity-10 bg-info'}">
                                <div class="d-flex justify-content-between">
                                    <small class="fw-semibold">${escapeHtml(item.titulo)}</small>
                                    <small class="text-muted">${escapeHtml(item.created_at ?? '')}</small>
                                </div>
                                <div class="small text-muted mb-2">${escapeHtml(item.mensagem)}</div>
                                ${item.url ? `<a href="${escapeHtml(item.url)}" class="btn btn-sm btn-outline-primary">Abrir</a>` : ''}
                            </div>
                        `).join('');
                    }
                }

                if (data.items?.[0] && unread > 0 && lastUnreadCount !== null && unread > lastUnreadCount) {
                    showToast(data.items[0].titulo, data.items[0].mensagem);
                }

                lastUnreadCount = unread;
            };

            if (!reverbKey || typeof window.Pusher === 'undefined') {
                return;
            }

            const pusher = new window.Pusher(reverbKey, {
                wsHost: reverbHost,
                wsPort: reverbPort,
                wssPort: reverbPort,
                forceTLS: reverbScheme === 'https',
                enabledTransports: ['ws', 'wss'],
                disableStats: true,
            });

            const channel = pusher.subscribe('system-updates');

            refreshNotificationBell().catch(() => {});

            channel.bind('system.updated', (payload) => {
                if (payload?.entity === 'notificacao') {
                    refreshNotificationBell().catch(() => {});
                    return;
                }

                if (unsavedChanges) {
                    showUpdateBanner();
                    return;
                }

                window.location.reload();
            });
        })();
    </script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /Users/mac/Herd/Fraude/resources/views/layouts/app.blade.php ENDPATH**/ ?>