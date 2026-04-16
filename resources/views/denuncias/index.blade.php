@extends('layouts.app')

@section('title', 'Denúncias')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="page-title">Denúncias Reportadas</h1>
        </div>
        <div class="col-md-4 text-md-end">
            @auth
                <a href="{{ route('denuncias.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nova Denúncia
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Nova Denúncia
                </a>
            @endauth
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
                            @if($denuncia->localizacao)
                                <span class="badge bg-info">{{ $denuncia->localizacao }}</span>
                            @endif
                        </div>

                        <div class="small text-muted mb-3">
                            <i class="bi bi-person"></i> {{ $denuncia->user->name }} | 
                            <i class="bi bi-calendar"></i> {{ $denuncia->created_at->format('d/m/Y H:i') }}
                        </div>

                        <a href="{{ route('denuncias.show', $denuncia) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye"></i> Detalhes
                        </a>
                        @if(auth()->check() && auth()->id() === $denuncia->user_id && $denuncia->status === 'pendente')
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
                    <i class="bi bi-info-circle"></i> Nenhuma denúncia reportada ainda.
                </div>
            </div>
        @endforelse
    </div>

    <div class="row mt-4">
        <div class="col-12">
            {{ $denuncias->links() }}
        </div>
    </div>

    <!-- Contatos de Apoio -->
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="page-title">Contatos de Apoio</h3>
            <p class="text-muted">Em caso de emergência ou necessidade de apoio adicional, entre em contato com as autoridades competentes em Angola:</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="bi bi-shield-check" style="font-size: 3rem; color: #007bff;"></i>
                    <h5 class="card-title mt-3">Polícia Nacional de Angola</h5>
                    <p class="card-text">Para denúncias criminais e apoio policial.</p>
                    <a href="tel:113" class="btn btn-primary">Ligar: 113</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="bi bi-bank" style="font-size: 3rem; color: #28a745;"></i>
                    <h5 class="card-title mt-3">Centro de Integridade Pública (CIP)</h5>
                    <p class="card-text">Combate à corrupção e fraudes institucionais.</p>
                    <a href="tel:+244222394000" class="btn btn-success">Ligar: +244 222 394 000</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="bi bi-house-lock" style="font-size: 3rem; color: #ffc107;"></i>
                    <h5 class="card-title mt-3">Centro Integrado de Segurança Pública (CISPE)</h5>
                    <p class="card-text">Especializado em crimes cibernéticos e segurança digital.</p>
                    <a href="tel:+244923000000" class="btn btn-warning">Ligar: +244 923 000 000</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="bi bi-search" style="font-size: 3rem; color: #17a2b8;"></i>
                    <h5 class="card-title mt-3">Serviço de Investigação Criminal (SIC)</h5>
                    <p class="card-text">Investigação de crimes e apoio em processos criminais.</p>
                    <a href="#" class="btn btn-info disabled" aria-disabled="true">Contacto presencial recomendado</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
