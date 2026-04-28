@extends('layouts.app')

@section('title', 'Minhas Notificações')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="page-title mb-0">Minhas Notificações</h1>
        <form action="{{ route('notificacoes.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary">Marcar todas como lidas</button>
        </form>
    </div>

    <div class="card">
        <div class="list-group list-group-flush">
            @forelse($notificacoes as $notificacao)
                <div class="list-group-item py-3">
                    <div class="d-flex justify-content-between align-items-start gap-3">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h6 class="mb-0">{{ $notificacao->titulo }}</h6>
                                @if(!$notificacao->é_lida)
                                    <span class="badge bg-danger">Nova</span>
                                @endif
                            </div>
                            <p class="text-muted small mb-2">{{ $notificacao->mensagem }}</p>
                            <small class="text-muted">{{ $notificacao->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            @if($notificacao->url)
                                <a href="{{ $notificacao->url }}" class="btn btn-sm btn-outline-primary">Abrir</a>
                            @endif
                            @if(!$notificacao->é_lida)
                                <form action="{{ route('notificacoes.read', $notificacao) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Marcar lida</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="list-group-item py-4 text-center text-muted">
                    Nenhuma notificação encontrada.
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-4">
        {{ $notificacoes->links() }}
    </div>
</div>
@endsection

