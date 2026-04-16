@extends('admin.layout')

@section('title', 'Admin - Usuários')

@section('admin-content')
<h1 class="page-title">Gerenciar Usuários</h1>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Perfil</th>
                        <th>Status</th>
                        <th>Cadastro</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td><span class="badge bg-secondary">{{ ucfirst($usuario->role) }}</span></td>
                            <td>
                                <span class="badge bg-{{ $usuario->is_active ? 'success' : 'danger' }}">
                                    {{ $usuario->is_active ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                @if(auth()->id() !== $usuario->id)
                                    <form action="{{ route('admin.usuarios.delete', $usuario) }}" method="POST" class="d-inline ms-1" onsubmit="return confirm('Tem certeza que deseja eliminar este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                @else
                                    <span class="badge bg-light text-dark border">Você</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Nenhum usuário encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $usuarios->links() }}
</div>
@endsection
