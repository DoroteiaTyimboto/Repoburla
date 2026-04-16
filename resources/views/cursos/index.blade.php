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

    <!-- Anúncios sobre Segurança da Internet -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="page-title">Dicas de Segurança na Internet</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-lock-fill text-info me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Use Senhas Fortes</h5>
                    </div>
                    <p class="card-text">Crie senhas com pelo menos 12 caracteres, combinando letras maiúsculas, minúsculas, números e símbolos. Evite usar informações pessoais óbvias.</p>
                    <a href="#" class="btn btn-outline-info">Saiba Mais</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-eye-slash-fill text-warning me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Verifique Antes de Clicar</h5>
                    </div>
                    <p class="card-text">Sempre verifique a URL antes de clicar em links suspeitos. Use nosso testador de links para analisar endereços duvidosos.</p>
                    <a href="{{ route('testador.index') }}" class="btn btn-outline-warning">Testar Link</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-shield-check-fill text-success me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Atualize seus Dispositivos</h5>
                    </div>
                    <p class="card-text">Mantenha seu sistema operacional, navegadores e aplicativos sempre atualizados para corrigir vulnerabilidades de segurança.</p>
                    <a href="#" class="btn btn-outline-success">Dicas de Atualização</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-3" style="font-size: 2rem;"></i>
                        <h5 class="card-title mb-0">Não Compartilhe Dados Sensíveis</h5>
                    </div>
                    <p class="card-text">Evite compartilhar informações pessoais, bancárias ou senhas em sites não confiáveis ou por email suspeito.</p>
                    <a href="{{ route('denuncias.create') }}" class="btn btn-outline-danger">Reportar Fraude</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            {{ $cursos->links() }}
        </div>
    </div>
</div>
@endsection
