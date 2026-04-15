@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Administração</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary text-start">Dashboard</a>
                        <a href="{{ route('admin.denuncias') }}" class="btn btn-outline-primary text-start">Denúncias</a>
                        <a href="{{ route('admin.usuarios') }}" class="btn btn-outline-primary text-start">Usuários</a>
                        <a href="{{ route('admin.cursos') }}" class="btn btn-outline-primary text-start">Cursos</a>
                        <a href="{{ route('admin.relatorios') }}" class="btn btn-outline-primary text-start">Relatórios</a>
                        <a href="{{ route('admin.notificacoes') }}" class="btn btn-outline-primary text-start">Notificações</a>
                        <a href="{{ route('admin.configuracoes') }}" class="btn btn-outline-primary text-start">Configurações</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            @yield('admin-content')
        </div>
    </div>
</div>
@endsection
