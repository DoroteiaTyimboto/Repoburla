@extends('admin.layout')

@section('title', 'Admin - Denúncias')

@section('admin-content')
<h1 class="page-title">Gerenciar Denúncias</h1>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.denuncias.filter') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="busca" class="form-control" placeholder="Buscar..." value="{{ request('busca') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Todos os status</option>
                    <option value="pendente" @selected(request('status') === 'pendente')>Pendente</option>
                    <option value="aprovado" @selected(request('status') === 'aprovado')>Aprovado</option>
                    <option value="resolvido" @selected(request('status') === 'resolvido')>Resolvido</option>
                    <option value="rejeitado" @selected(request('status') === 'rejeitado')>Rejeitado</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="prioridade" class="form-select">
                    <option value="">Todas as prioridades</option>
                    <option value="alta" @selected(request('prioridade') === 'alta')>Alta</option>
                    <option value="media" @selected(request('prioridade') === 'media')>Média</option>
                    <option value="baixa" @selected(request('prioridade') === 'baixa')>Baixa</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="tipo" class="form-select">
                    <option value="">Todos os tipos</option>
                    <option value="phishing" @selected(request('tipo') === 'phishing')>Phishing</option>
                    <option value="malware" @selected(request('tipo') === 'malware')>Malware</option>
                    <option value="fraude" @selected(request('tipo') === 'fraude')>Fraude</option>
                </select>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
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
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Localização</th>
                        <th>Data</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($denuncias as $denuncia)
                        <tr>
                            <td>
                                <strong>{{ $denuncia->titulo }}</strong>
                                <div class="small text-muted">{{ \Illuminate\Support\Str::limit($denuncia->descricao, 80) }}</div>
                            </td>
                            <td>{{ ucfirst($denuncia->tipo ?? 'N/A') }}</td>
                            <td><span class="badge badge-status-{{ $denuncia->status }}">{{ ucfirst($denuncia->status) }}</span></td>
                            <td><span class="badge bg-{{ getPrioridadeColor($denuncia->prioridade) }}">{{ ucfirst($denuncia->prioridade) }}</span></td>
                            <td>{{ $denuncia->localizacao ?? 'N/A' }}</td>
                            <td>{{ $denuncia->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('denuncias.show', $denuncia) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                <form action="{{ route('denuncias.destroy', $denuncia) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Tem certeza que deseja eliminar esta denúncia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Nenhuma denúncia encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $denuncias->links() }}
</div>
@endsection
