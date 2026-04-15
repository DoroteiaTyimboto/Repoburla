@extends('admin.layout')

@section('title', 'Notificações')

@section('admin-content')
<h1 class="page-title">Notificações</h1>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.notificacoes.send') }}" method="POST" class="row g-3">
            @csrf
            <div class="col-md-4">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select" required>
                    <option value="sistema">Sistema</option>
                    <option value="denuncia">Denúncia</option>
                    <option value="curso">Curso</option>
                    <option value="comentario">Comentário</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="col-12">
                <label class="form-label">Mensagem</label>
                <textarea name="mensagem" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label">Enviar para usuário ID</label>
                <input type="number" name="para_usuario_id" class="form-control">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="para_todos" value="1" id="para_todos">
                    <label class="form-check-label" for="para_todos">Enviar para todos</label>
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Enviar notificação</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Usuário</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notificacoes as $notificacao)
                        <tr>
                            <td>
                                <strong>{{ $notificacao->titulo }}</strong>
                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit($notificacao->mensagem, 90) }}</div>
                            </td>
                            <td>{{ ucfirst($notificacao->tipo) }}</td>
                            <td>{{ $notificacao->user_id }}</td>
                            <td>{{ $notificacao->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Nenhuma notificação encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $notificacoes->links() }}
</div>
@endsection
