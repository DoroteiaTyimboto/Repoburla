@extends('admin.layout')

@section('title', 'Configurações')

@section('admin-content')
<h1 class="page-title">Configurações do Sistema</h1>

<div class="card">
    <div class="card-body">
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nome do Sistema</label>
                <input type="text" name="site_name" class="form-control" value="RepoBurla">
            </div>
            
            <div class="mb-3">
                <label class="form-label">E-mail de Contato</label>
                <input type="email" name="contact_email" class="form-control" value="contato@repoburla.com">
            </div>

            <div class="mb-3">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="maintenance_mode" id="maintenance_mode">
                    <label class="form-check-label" for="maintenance_mode">Ativar Modo de Manutenção</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>
</div>
@endsection
