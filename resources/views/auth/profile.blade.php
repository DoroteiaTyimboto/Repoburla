@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Meu Perfil</h1>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="mx-auto d-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width: 90px; height: 90px; background: linear-gradient(135deg, #3498db 0%, #2c3e50 100%); font-size: 2rem;">
                            {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($user->name, 0, 1)) }}
                        </div>
                    </div>

                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <div class="small text-muted">
                        <div class="mb-2">
                            <strong>Perfil:</strong> {{ ucfirst($user->role ?? 'user') }}
                        </div>
                        <div class="mb-2">
                            <strong>Telefone:</strong> {{ $user->phone ?: 'Não informado' }}
                        </div>
                        <div class="mb-2">
                            <strong>País:</strong> {{ $user->country ?: 'Não informado' }}
                        </div>
                        <div>
                            <strong>Conta criada em:</strong> {{ $user->created_at?->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Atualizar Informações</h5>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    class="form-control"
                                    value="{{ $user->email }}"
                                    disabled
                                >
                                <div class="form-text">O email não pode ser alterado nesta tela.</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telefone</label>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">País</label>
                                <input
                                    type="text"
                                    id="country"
                                    name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country', $user->country) }}"
                                >
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="mb-3">Alterar Senha</h6>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Senha atual</label>
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                >
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="new_password" class="form-label">Nova senha</label>
                                <input
                                    type="password"
                                    id="new_password"
                                    name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror"
                                >
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="new_password_confirmation" class="form-label">Confirmar nova senha</label>
                                <input
                                    type="password"
                                    id="new_password_confirmation"
                                    name="new_password_confirmation"
                                    class="form-control"
                                >
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
