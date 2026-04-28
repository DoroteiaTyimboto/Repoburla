@extends('layouts.app')

@section('title', 'Editar Denúncia')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="page-title">Editar Denúncia</h1>

            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <form action="{{ route('denuncias.update', $denuncia) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Título da Denúncia *</label>
                            <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
                                   value="{{ old('titulo', $denuncia->titulo) }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tipo de Fraude *</label>
                                <select name="tipo" class="form-select @error('tipo') is-invalid @enderror" required>
                                    <option value="">Selecione...</option>
                                    <option value="phishing" {{ old('tipo', $denuncia->tipo) === 'phishing' ? 'selected' : '' }}>Phishing</option>
                                    <option value="malware" {{ old('tipo', $denuncia->tipo) === 'malware' ? 'selected' : '' }}>Malware</option>
                                    <option value="fraude" {{ old('tipo', $denuncia->tipo) === 'fraude' ? 'selected' : '' }}>Fraude Financeira</option>
                                    <option value="roubo_identidade" {{ old('tipo', $denuncia->tipo) === 'roubo_identidade' ? 'selected' : '' }}>Roubo de Identidade</option>
                                    <option value="spam" {{ old('tipo', $denuncia->tipo) === 'spam' ? 'selected' : '' }}>Spam</option>
                                    <option value="outro" {{ old('tipo', $denuncia->tipo) === 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Prioridade</label>
                                <select name="prioridade" class="form-select @error('prioridade') is-invalid @enderror">
                                    <option value="baixa" {{ old('prioridade', $denuncia->prioridade) === 'baixa' ? 'selected' : '' }}>Baixa</option>
                                    <option value="media" {{ old('prioridade', $denuncia->prioridade) === 'media' ? 'selected' : '' }}>Média</option>
                                    <option value="alta" {{ old('prioridade', $denuncia->prioridade) === 'alta' ? 'selected' : '' }}>Alta</option>
                                </select>
                                @error('prioridade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descrição Detalhada *</label>
                            <textarea name="descricao" class="form-control @error('descricao') is-invalid @enderror"
                                      rows="5" required>{{ old('descricao', $denuncia->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">URL Suspeita (opcional)</label>
                            <input type="url" name="url_suspeita" class="form-control @error('url_suspeita') is-invalid @enderror"
                                   value="{{ old('url_suspeita', $denuncia->url_suspeita) }}">
                            @error('url_suspeita')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Adicionar Provas (imagem, PDF, vídeo ou áudio)</label>
                            <input type="file" name="provas[]" class="form-control @error('provas') is-invalid @enderror @error('provas.*') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.webp,.pdf,.mp4,.mov,.webm,.mp3,.wav,.m4a,.ogg,.aac,image/*,application/pdf,video/*,audio/*" multiple>
                            <small class="text-muted">Pode anexar novos prints, PDFs, vídeos e áudios (máx. 50MB por ficheiro).</small>
                            @error('provas')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('provas.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Localização (opcional)</label>
                            <input type="text" name="localizacao" class="form-control @error('localizacao') is-invalid @enderror"
                                   value="{{ old('localizacao', $denuncia->localizacao) }}">
                            @error('localizacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary btn-lg flex-sm-grow-1">
                                <i class="bi bi-check-circle"></i> Salvar Alterações
                            </button>
                            <a href="{{ route('denuncias.show', $denuncia) }}" class="btn btn-secondary btn-lg flex-sm-grow-1">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
