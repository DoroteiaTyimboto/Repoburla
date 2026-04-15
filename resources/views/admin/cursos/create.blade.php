@extends('admin.layout')

@section('title', 'Novo Curso')

@section('admin-content')
<h1 class="page-title">Novo Curso</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.cursos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ old('titulo') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="4" required>{{ old('descricao') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Conteúdo</label>
                <textarea name="conteudo" class="form-control" rows="6">{{ old('conteudo') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nível</label>
                    <select name="nivel" class="form-select" required>
                        <option value="iniciante">Iniciante</option>
                        <option value="intermediario">Intermediário</option>
                        <option value="avancado">Avançado</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Duração</label>
                    <input type="number" name="duracao_minutos" class="form-control" value="{{ old('duracao_minutos') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Categoria</label>
                    <input type="text" name="categoria" class="form-control" value="{{ old('categoria') }}">
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_published" value="1" id="cursoPublicado">
                <label class="form-check-label" for="cursoPublicado">Publicar imediatamente</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.cursos') }}" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Criar Curso</button>
            </div>
        </form>
    </div>
</div>
@endsection
