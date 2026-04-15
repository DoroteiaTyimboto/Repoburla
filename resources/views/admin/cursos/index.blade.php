@extends('admin.layout')

@section('title', 'Admin - Cursos')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0">Gerenciar Cursos</h1>
    <a href="{{ route('admin.cursos.create') }}" class="btn btn-primary">Novo Curso</a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Título</th>
                        <th>Nível</th>
                        <th>Categoria</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cursos as $curso)
                        <tr>
                            <td>{{ $curso->titulo }}</td>
                            <td>{{ ucfirst($curso->nivel) }}</td>
                            <td>{{ $curso->categoria ?? 'Geral' }}</td>
                            <td>
                                <span class="badge bg-{{ $curso->is_published ? 'success' : 'secondary' }}">
                                    {{ $curso->is_published ? 'Publicado' : 'Rascunho' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.cursos.edit', $curso) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Nenhum curso encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $cursos->links() }}
</div>
@endsection
