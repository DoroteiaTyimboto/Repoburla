@extends('admin.layout')

@section('title', 'Relatórios')

@section('admin-content')
<h1 class="page-title">Relatórios</h1>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Denúncias por Tipo</h5></div>
            <div class="card-body">
                @forelse($relatorios['denunciasPorTipo'] as $tipo => $total)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ ucfirst($tipo ?? 'Não informado') }}</span>
                        <strong>{{ $total }}</strong>
                    </div>
                @empty
                    <div class="text-muted">Sem dados.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Denúncias por Status</h5></div>
            <div class="card-body">
                @forelse($relatorios['denunciasPorStatus'] as $status => $total)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ ucfirst($status) }}</span>
                        <strong>{{ $total }}</strong>
                    </div>
                @empty
                    <div class="text-muted">Sem dados.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
