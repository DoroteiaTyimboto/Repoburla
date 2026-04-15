@extends('admin.layout')

@section('title', 'Dashboard Admin')

@section('admin-content')
<h1 class="page-title">Painel Administrativo</h1>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Usuários</h6>
                <h2 class="fw-bold text-primary">{{ $stats['totalUsuarios'] }}</h2>
                <small class="text-muted">Ativos: {{ $stats['usuariosAtivos'] }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Denúncias</h6>
                <h2 class="fw-bold text-danger">{{ $stats['totalDenuncias'] }}</h2>
                <small class="text-muted">Pendentes: {{ $stats['denunciasPendentes'] }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <h6>Cursos</h6>
                <h2 class="fw-bold text-success">{{ $stats['totalCursos'] }}</h2>
                <small class="text-muted">Publicados: {{ $stats['cursosPublicados'] }}</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Denúncias Pendentes</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($denunciasPendentes as $denuncia)
                        <a href="{{ route('denuncias.show', $denuncia) }}" class="list-group-item list-group-item-action">
                            <strong>{{ $denuncia->titulo }}</strong>
                            <div class="small text-muted mt-1">
                                {{ $denuncia->prioridade }} | {{ $denuncia->created_at->format('d/m/Y H:i') }}
                            </div>
                        </a>
                    @empty
                        <div class="text-muted text-center py-4">Nenhuma denúncia pendente.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Usuários Recentes</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse($usuariosRecentes as $usuario)
                        <div class="list-group-item">
                            <strong>{{ $usuario->name }}</strong>
                            <div class="small text-muted mt-1">
                                {{ $usuario->email }} | {{ ucfirst($usuario->role) }}
                            </div>
                        </div>
                    @empty
                        <div class="text-muted text-center py-4">Nenhum usuário recente.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
