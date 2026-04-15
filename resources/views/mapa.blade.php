@extends('layouts.app')

@section('title', 'Mapa de Denúncias')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Mapa de Denúncias</h1>

    <div class="card mb-4">
        <div class="card-body">
            <p class="lead mb-3">
                Acompanhe as denúncias registradas por localização. Esta visão ajuda a identificar áreas com maior concentração de casos reportados.
            </p>

            @php
                $porLocalizacao = $denuncias
                    ->groupBy('localizacao')
                    ->map(fn ($grupo) => [
                        'total' => $grupo->count(),
                        'pendente' => $grupo->where('status', 'pendente')->count(),
                        'aprovado' => $grupo->where('status', 'aprovado')->count(),
                        'resolvido' => $grupo->where('status', 'resolvido')->count(),
                    ])
                    ->sortByDesc('total');
            @endphp

            <div class="row text-center">
                <div class="col-md-4 mb-3">
                    <h3 class="fw-bold">{{ $denuncias->count() }}</h3>
                    <small class="text-muted">Denúncias com localização</small>
                </div>
                <div class="col-md-4 mb-3">
                    <h3 class="fw-bold">{{ $porLocalizacao->count() }}</h3>
                    <small class="text-muted">Localizações registradas</small>
                </div>
                <div class="col-md-4 mb-3">
                    <h3 class="fw-bold">{{ $porLocalizacao->keys()->first() ?? 'N/A' }}</h3>
                    <small class="text-muted">Local com mais ocorrências</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Resumo por Localização</h5>
                </div>
                <div class="card-body">
                    @forelse($porLocalizacao as $localizacao => $dados)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>{{ $localizacao }}</strong>
                                <span class="badge bg-primary">{{ $dados['total'] }}</span>
                            </div>
                            <div class="small text-muted">
                                Pendentes: {{ $dados['pendente'] }} |
                                Aprovadas: {{ $dados['aprovado'] }} |
                                Resolvidas: {{ $dados['resolvido'] }}
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle"></i> Ainda não existem denúncias com localização informada.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Denúncias Registradas</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($denuncias->sortByDesc('created_at') as $denuncia)
                            <a href="{{ route('denuncias.show', $denuncia) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-start">
                                    <div class="me-3">
                                        <h6 class="mb-1">{{ $denuncia->titulo }}</h6>
                                        <p class="mb-1 text-muted">
                                            {{ \Illuminate\Support\Str::limit($denuncia->descricao, 120) }}
                                        </p>
                                        <div class="small">
                                            <span class="badge bg-info text-dark">{{ $denuncia->localizacao }}</span>
                                            <span class="badge badge-status-{{ $denuncia->status }}">{{ ucfirst($denuncia->status) }}</span>
                                            <span class="badge bg-{{ getPrioridadeColor($denuncia->prioridade) }}">{{ ucfirst($denuncia->prioridade) }}</span>
                                        </div>
                                    </div>
                                    <small class="text-muted text-nowrap">{{ $denuncia->created_at->format('d/m/Y') }}</small>
                                </div>
                            </a>
                        @empty
                            <div class="text-muted text-center py-4">Nenhuma denúncia localizada encontrada.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
