@extends('admin.layout')

@section('title', 'Editar Usuário')

@section('admin-content')
<h1 class="page-title">Editar Usuário</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.usuarios.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Perfil</label>
                    <select name="role" class="form-select" required>
                        <option value="user" @selected(old('role', $user->role) === 'user')>Usuário</option>
                        <option value="moderator" @selected(old('role', $user->role) === 'moderator')>Moderador</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" @selected((string) old('is_active', (int) $user->is_active) === '1')>Ativo</option>
                        <option value="0" @selected((string) old('is_active', (int) $user->is_active) === '0')>Inativo</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection
