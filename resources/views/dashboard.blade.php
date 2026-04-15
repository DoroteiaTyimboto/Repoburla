@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Dashboard - Bem-vindo, {{ $user->name }}!</h1>

    <!-- Notificações não lidas -->
    @if($notificacoes->count() > 0)
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-bell"></i> Você tem {{ $notificacoes->count() }} notificações não lidas</strong>
            @foreach($notificacoes as $notif)
                <div class="small mt-2">• {{ $notif->titulo }}: {{ $notif->mensagem }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats do usuário -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center" style="border-top: 4px solid #e74c3c;">
                <div class="card-body">
                    <i class="bi bi-exclamation-triangle" style="font-size: 2rem; color: #e74c3c;"></i>
                    <h6 class="mt-2">Minhas Denúncias</h6>
                    <h3 class="fw-bold">{{ $meusRelatorios['total'] }}</h3>
                    <small class="text-muted">
                        Pendentes: {{ $meusRelatorios['pendente'] }} | 
                        Aprovadas: {{ $meusRelatorios['aprovado'] }}
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center" style="border-top: 4px solid #27ae60;">
                <div class="card-body">
                    <i class="bi bi-book" style="font-size: 2rem; color: #27ae60;"></i>
                    <h6 class="mt-2">Meus Cursos</h6>
                    <h3 class="fw-bold">{{ $cursosDados['total'] }}</h3>
                    <small class="text-muted">
                        Em progresso: {{ $cursosDados['emProgresso'] }} | 
                        Concluídos: {{ $cursosDados['concluido'] }}
                    </small>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card text-center" style="border-top: 4px solid #f39c12;">
                <div class="card-body">
                    <i class="bi bi-link" style="font-size: 2rem; color: #f39c12;"></i>
                    <h6 class="mt-2">Ações Rápidas</h6>
                    <div class="mt-2">
                        <a href="{{ route('testador.index') }}" class="btn btn-sm btn-warning">Testador</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin section -->
    @if($user->isModerator())
        <h3 class="page-title mt-5">Painel Administrativo</h3>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Denúncias Pendentes</h6>
                        <h2 class="fw-bold text-danger">{{ $sistemaDados['denunciasPendentes'] }}</h2>
                        <a href="{{ route('admin.denuncias') }}" class="btn btn-sm btn-outline-danger">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Total de Usuários</h6>
                        <h2 class="fw-bold text-info">{{ $sistemaDados['totalUsuarios'] }}</h2>
                        <a href="{{ route('admin.usuarios') }}" class="btn btn-sm btn-outline-info">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Cursos Publicados</h6>
                        <h2 class="fw-bold text-success">{{ $sistemaDados['cursosPublicados'] }}</h2>
                        <a href="{{ route('admin.cursos') }}" class="btn btn-sm btn-outline-success">Gerenciar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>Testador de Links</h6>
                        <h2 class="fw-bold text-warning">{{ $sistemaDados['totalUsuarios'] ?? 0 }}</h2>
                        <a href="{{ route('testador.index') }}" class="btn btn-sm btn-outline-warning">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Links -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="page-title">Atalhos</h3>
            <div class="d-grid gap-2 d-sm-flex">
                <a href="{{ route('denuncias.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Reportar Fraude
                </a>
                <a href="{{ route('cursos.index') }}" class="btn btn-success">
                    <i class="bi bi-book"></i> Ver Cursos
                </a>
                <a href="{{ route('testador.index') }}" class="btn btn-warning">
                    <i class="bi bi-link"></i> Testar Link
                </a>
                <a href="{{ route('profile') }}" class="btn btn-secondary">
                    <i class="bi bi-person"></i> Meu Perfil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
