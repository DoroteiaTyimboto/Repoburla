<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
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
                    <a class="nav-link" href="{{ route('home') }}">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('denuncias.index') }}">Denúncias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cursos.index') }}">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('testador.index') }}">Testador de Links</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mapa') }}">Mapa</a>
                </li>

                @auth
                    @php
                        $notificacoesMenu = auth()->user()->notificacoes()->limit(6)->get();
                        $naoLidasCount = auth()->user()->notificacoes()->naoLidas()->count();
                    @endphp

                    <li class="nav-item dropdown me-lg-2">
                        <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5"></i>
                            <span id="notif-count-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger {{ $naoLidasCount > 0 ? '' : 'd-none' }}">
                                {{ $naoLidasCount }}
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0 shadow" style="min-width: 360px;">
                            <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                                <strong>Notificações</strong>
                                <form action="{{ route('notificacoes.read-all') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0">Marcar todas lidas</button>
                                </form>
                            </div>

                            <div id="notif-list">
                                @forelse($notificacoesMenu as $notif)
                                    <div class="px-3 py-2 border-bottom {{ $notif->é_lida ? '' : 'bg-opacity-10 bg-info' }}">
                                        <div class="d-flex justify-content-between">
                                            <small class="fw-semibold">{{ $notif->titulo }}</small>
                                            <small class="text-muted">{{ $notif->created_at->format('d/m H:i') }}</small>
                                        </div>
                                        <div class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit($notif->mensagem, 90) }}</div>
                                        <div class="d-flex gap-2">
                                            @if($notif->url)
                                                <a href="{{ $notif->url }}" class="btn btn-sm btn-outline-primary">Abrir</a>
                                            @endif
                                            @if(!$notif->é_lida)
                                                <form action="{{ route('notificacoes.read', $notif) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Marcar lida</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-3 py-3 text-muted small">Sem notificações no momento.</div>
                                @endforelse
                            </div>

                            <div class="px-3 py-2 text-center">
                                <a href="{{ route('notificacoes.index') }}" class="btn btn-sm btn-primary">Ver todas</a>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Perfil</a></li>
                            <li><a class="dropdown-item" href="{{ route('my-denuncias') }}">Minhas Denúncias</a></li>
                            <li><a class="dropdown-item" href="{{ route('my-cursos') }}">Meus Cursos</a></li>

                            @if(auth()->user()->isModerator())
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.denuncias') }}">Gerenciar Denúncias</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.usuarios') }}">Gerenciar Usuários</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.cursos') }}">Gerenciar Cursos</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.relatorios') }}">Relatórios</a></li>
                            @endif

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-light text-primary fw-semibold rounded-pill px-3 ms-lg-2 mt-2 mt-lg-0" href="{{ route('register') }}">Registrar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
