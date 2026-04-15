@extends('layouts.app')

@section('title', 'Reportar Nova Denúncia')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title">Reportar Nova Denúncia</h1>

            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <form action="{{ route('denuncias.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Título da Denúncia *</label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" 
                                   value="{{ old('titulo') }}" required placeholder="Ex: Phishing de conta bancária">
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo de Fraude *</label>
                                <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                    <option value="">Selecione...</option>
                                    <option value="phishing" {{ old('tipo') === 'phishing' ? 'selected' : '' }}>Phishing</option>
                                    <option value="malware" {{ old('tipo') === 'malware' ? 'selected' : '' }}>Malware</option>
                                    <option value="fraude" {{ old('tipo') === 'fraude' ? 'selected' : '' }}>Fraude Financeira</option>
                                    <option value="roubo_identidade" {{ old('tipo') === 'roubo_identidade' ? 'selected' : '' }}>Roubo de Identidade</option>
                                    <option value="spam" {{ old('tipo') === 'spam' ? 'selected' : '' }}>Spam</option>
                                    <option value="outro" {{ old('tipo') === 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Prioridade</label>
                                <select name="prioridade" class="form-select">
                                    <option value="media" selected>Média</option>
                                    <option value="baixa">Baixa</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição Detalhada *</label>
                            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror" 
                                      rows="5" required placeholder="Descreva com detalhes o incidente...">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">URL Suspeita (opcional)</label>
                            <input type="url" name="url_suspeita" class="form-control @error('url_suspeita') is-invalid @enderror" 
                                   value="{{ old('url_suspeita') }}" placeholder="https://exemplo.com">
                            @error('url_suspeita')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Localização (opcional)</label>
                                <input type="text" name="localizacao" class="form-control" 
                                       value="{{ old('localizacao') }}" placeholder="Ex: Brasil, São Paulo">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Data do Incidente (opcional)</label>
                                <input type="date" name="data_incidente" class="form-control @error('data_incidente') is-invalid @enderror" 
                                       value="{{ old('data_incidente') }}">
                                @error('data_incidente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="aceitar" required>
                            <label class="form-check-label" for="aceitar">
                                Confirmo que as informações acima são precisas e verdadeiras
                            </label>
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary btn-lg flex-sm-grow-1">
                                <i class="bi bi-check-circle"></i> Enviar Denúncia
                            </button>
                            <a href="{{ route('denuncias.index') }}" class="btn btn-secondary btn-lg flex-sm-grow-1">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4">
                <h6><i class="bi bi-info-circle"></i> Informações Importantes</h6>
                <ul class="mb-0 mt-2">
                    <li>Todas as denúncias são revisadas antes de publicação</li>
                    <li>Forneca o máximo de detalhes possível para uma análise melhor</li>
                    <li>Screenshots ou evidências ajudam bastante</li>
                    <li>Dados pessoais serão mantidos confidenciais</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
