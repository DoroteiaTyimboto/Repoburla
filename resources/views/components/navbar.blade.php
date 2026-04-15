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
                        <a class="nav-link btn btn-light text-primary ms-2" href="{{ route('register') }}">Registrar</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
