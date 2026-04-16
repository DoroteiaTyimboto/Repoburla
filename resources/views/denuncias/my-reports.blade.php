@extends('layouts.app')

@section('title', 'Minhas Denúncias')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="page-title">Minhas Denúncias</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('denuncias.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nova Denúncia
            </a>
        </div>
    </div>

    <div class="row">
        @forelse($denuncias as $denuncia)
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title">{{ $denuncia->titulo }}</h5>
                            <span class="badge badge-status-{{ $denuncia->status }}">
                                {{ ucfirst($denuncia->status) }}
                            </span>
                        </div>

                        <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($denuncia->descricao, 150) }}</p>

                        <div class="mb-3">
                            <span class="badge bg-secondary">{{ ucfirst($denuncia->tipo) }}</span>
                            <span class="badge" style="background-color: {{ match($denuncia->prioridade) { 'alta' => '#e74c3c', 'media' => '#f39c12', 'baixa' => '#27ae60' } }};">
                                {{ ucfirst($denuncia->prioridade) }}
                            </span>
                        </div>

                        <div class="small text-muted mb-3">
                            <i class="bi bi-calendar"></i> {{ $denuncia->created_at->format('d/m/Y H:i') }}
                        </div>

                        <a href="{{ route('denuncias.show', $denuncia) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detalhes
                        </a>
                        @if($denuncia->status === 'pendente')
                            <a href="{{ route('denuncias.edit', $denuncia) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> Você ainda não criou nenhuma denúncia.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12">
            {{ $denuncias->links() }}
        </div>
    </div>
</div>
@endsection
