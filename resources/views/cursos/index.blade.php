@extends('layouts.app')

@section('title', 'Cursos')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Cursos de Segurança Digital</h1>

    <div class="row mb-4">
        <div class="col-md-12">
            <form action="{{ route('cursos.filter') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="busca" class="form-control" placeholder="Buscar cursos..." value="{{ request('busca') }}">
                </div>
                <div class="col-md-3">
                    <select name="categoria" class="form-select">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat }}" {{ request('categoria') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
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
        @forelse($cursos as $curso)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($curso->imagem_capa)
                        <img src="{{ $curso->imagem_capa }}" class="card-img-top" alt="{{ $curso->titulo }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div style="height: 200px; background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); display: flex; align-items: center; justify-content: center; color: white;">
                            <i class="bi bi-book" style="font-size: 3rem;"></i>
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $curso->titulo }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit($curso->descricao, 100) }}</p>

                        <div class="mb-3">
                            <span class="badge bg-info">{{ ucfirst($curso->nivel) }}</span>
                            @if($curso->duracao_minutos)
                                <span class="badge bg-secondary">{{ $curso->duracao_minutos }} min</span>
                            @endif
                            @if($curso->categoria)
                                <span class="badge bg-primary">{{ $curso->categoria }}</span>
                            @endif
                        </div>

                        <div class="small text-muted mb-3">
                            <i class="bi bi-people"></i> {{ $curso->getTotalInscritos() }} inscritos | 
                            <i class="bi bi-percent"></i> {{ $curso->getTaxaConclusao() }}% concluído
                        </div>

                        @if($curso->getMediaAvaliacoes() > 0)
                            <div class="mb-3">
                                <i class="bi bi-star-fill" style="color: #f39c12;"></i>
                                {{ $curso->getMediaAvaliacoes() }}/5 ({{ $curso->avaliacoes()->count() }} avaliações)
                            </div>
                        @endif

                        <a href="{{ route('cursos.show', $curso) }}" class="btn btn-primary mt-auto">
                            <i class="bi bi-arrow-right"></i> Ver Curso
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Nenhum curso encontrado.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12">
            {{ $cursos->links() }}
        </div>
    </div>
</div>
@endsection
