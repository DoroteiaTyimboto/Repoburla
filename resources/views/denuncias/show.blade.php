@extends('layouts.app')

@section('title', $denuncia->titulo)

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h1 class="page-title">{{ $denuncia->titulo }}</h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge badge-status-{{ $denuncia->status }} me-2">
                                {{ ucfirst($denuncia->status) }}
                            </span>
                            <span class="badge bg-{{ getPrioridadeColor($denuncia->prioridade) }}">
                                {{ ucfirst($denuncia->prioridade) }}
                            </span>
                        </div>
                        @if(auth()->check() && (auth()->id() === $denuncia->user_id || auth()->user()->isModerator()) && $denuncia->status === 'pendente')
                            <a href="{{ route('denuncias.edit', $denuncia) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <small class="text-muted d-block">Reportado por</small>
                            <strong>{{ $denuncia->user->name }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">Data</small>
                            <strong>{{ $denuncia->created_at->format('d/m/Y H:i') }}</strong>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Descrição</h5>
                    <p class="lead">{{ $denuncia->descricao }}</p>

                    @if($denuncia->tipo)
                        <p><strong>Tipo:</strong> {{ ucfirst($denuncia->tipo) }}</p>
                    @endif

                    @if($denuncia->url_suspeita)
                        <p><strong>URL Suspeita:</strong> <code>{{ $denuncia->url_suspeita }}</code></p>
                    @endif

                    @if($denuncia->localizacao)
                        <p><strong>Localização:</strong> {{ $denuncia->localizacao }}</p>
                    @endif

                    @if($denuncia->data_incidente)
                        <p><strong>Data do Incidente:</strong> {{ $denuncia->data_incidente->format('d/m/Y') }}</p>
                    @endif

                    @if(is_array($denuncia->evidencias) && count($denuncia->evidencias) > 0)
                        <hr>
                        <h5 class="mb-3">Provas Anexadas</h5>
                        <div class="row g-3">
                            @foreach($denuncia->evidencias as $index => $evidencia)
                                @php
                                    $caminho = is_array($evidencia) ? ($evidencia['caminho'] ?? null) : $evidencia;
                                    $nome = is_array($evidencia) ? ($evidencia['nome'] ?? 'Prova ' . ($index + 1)) : 'Prova ' . ($index + 1);
                                    $mime = is_array($evidencia) ? ($evidencia['mime'] ?? null) : null;
                                    $isImage = is_string($mime) ? str_starts_with($mime, 'image/') : false;
                                    $isVideo = is_string($mime) ? str_starts_with($mime, 'video/') : false;
                                    $isAudio = is_string($mime) ? str_starts_with($mime, 'audio/') : false;
                                @endphp

                                @if($caminho)
                                    <div class="col-md-6">
                                        <div class="border rounded p-3 h-100">
                                            @if($isImage)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($caminho) }}" alt="{{ $nome }}" class="img-fluid rounded mb-2">
                                            @endif
                                            @if($isVideo)
                                                <video class="w-100 rounded mb-2" controls preload="metadata">
                                                    <source src="{{ \Illuminate\Support\Facades\Storage::url($caminho) }}" type="{{ $mime }}">
                                                    O seu navegador não suporta reprodução de vídeo.
                                                </video>
                                            @endif
                                            @if($isAudio)
                                                <audio class="w-100 mb-2" controls preload="metadata">
                                                    <source src="{{ \Illuminate\Support\Facades\Storage::url($caminho) }}" type="{{ $mime }}">
                                                    O seu navegador não suporta reprodução de áudio.
                                                </audio>
                                            @endif
                                            <div class="small fw-semibold text-break">{{ $nome }}</div>
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($caminho) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="bi bi-paperclip"></i> Abrir ficheiro
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if($denuncia->resultado_verificacao && is_array($denuncia->resultado_verificacao) && !empty($denuncia->resultado_verificacao))
                        <hr>
                        <h5>Resultado da Verificação</h5>
                        <div class="alert alert-info">
                            @foreach($denuncia->resultado_verificacao as $key => $value)
                                <strong>{{ ucfirst(str_replace('_', ' ', $key))}}:</strong> {{ $value }}<br>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Avaliações -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        Avaliações 
                        @if($mediaAvaliacoes > 0)
                            <span class="badge bg-warning ms-2">{{ $mediaAvaliacoes }}/5</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('denuncias.rate', $denuncia) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Sua Avaliação</label>
                                <div class="btn-group" role="group">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" class="btn-check" name="classificacao" id="btn{{ $i }}" value="{{ $i }}">
                                        <label class="btn btn-outline-warning" for="btn{{ $i }}">
                                            <i class="bi bi-star-fill"></i> {{ $i }}
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Avaliar</button>
                        </form>
                    @endauth

                    <div class="list-group">
                        @forelse($avaliacoes as $avaliacao)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>{{ $avaliacao->user->name }}</strong>
                                        <div class="text-warning">
                                            @for($i = 0; $i < $avaliacao->classificacao; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $avaliacao->created_at->format('d/m/Y') }}</small>
                                </div>
                                @if($avaliacao->comentario)
                                    <p class="small text-muted mt-2 mb-0">{{ $avaliacao->comentario }}</p>
                                @endif
                            </div>
                        @empty
                            <div class="text-muted text-center py-4">Nenhuma avaliação ainda</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Comentários -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Comentários ({{ $comentarios->total() }})</h5>
                </div>
                <div class="card-body">
                    @auth
                        <form action="{{ route('denuncias.comment', $denuncia) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea name="conteudo" class="form-control" rows="3" placeholder="Adicionar comentário..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Comentar</button>
                        </form>
                    @endauth

                    <div class="list-group">
                        @forelse($comentarios as $comentario)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comentario->user->name }}</strong>
                                    <small class="text-muted">{{ $comentario->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <p class="small text-muted mt-2 mb-0">{{ $comentario->conteudo }}</p>
                            </div>
                        @empty
                            <div class="text-muted text-center py-4">Nenhum comentário ainda</div>
                        @endforelse
                    </div>

                    @if($comentarios->hasPages())
                        <div class="mt-3">
                            {{ $comentarios->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informações laterais -->
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    <h6 class="card-title">Informações</h6>
                    <dl class="row">
                        <dt class="col-sm-6">Tipo:</dt>
                        <dd class="col-sm-6"><span class="badge bg-secondary">{{ ucfirst($denuncia->tipo) }}</span></dd>

                        <dt class="col-sm-6">Status:</dt>
                        <dd class="col-sm-6"><span class="badge badge-status-{{ $denuncia->status }}">{{ ucfirst($denuncia->status) }}</span></dd>

                        <dt class="col-sm-6">Prioridade:</dt>
                        <dd class="col-sm-6"><span class="badge bg-{{ getPrioridadeColor($denuncia->prioridade) }}">{{ ucfirst($denuncia->prioridade) }}</span></dd>

                        <dt class="col-sm-6">Comentários:</dt>
                        <dd class="col-sm-6">{{ $comentarios->total() }}</dd>

                        <dt class="col-sm-6">Avaliações:</dt>
                        <dd class="col-sm-6">{{ $avaliacoes->count() }}</dd>
                    </dl>

                    @if(auth()->check() && (auth()->user()->isModerator() || auth()->id() === $denuncia->user_id))
                        <hr>
                        <h6>Ações</h6>
                        <div class="d-grid gap-2">
                            @if(auth()->user()->isModerator() && $denuncia->status === 'pendente')
                                <form action="{{ route('denuncias.approve', $denuncia) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success w-100">
                                        <i class="bi bi-check-circle"></i> Aprovar
                                    </button>
                                </form>

                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                    <i class="bi bi-x-circle"></i> Rejeitar
                                </button>
                            @endif

                            @if($denuncia->status === 'aprovado')
                                @if((auth()->user()->isModerator() || auth()->id() === $denuncia->user_id) && ($denuncia->resultado_verificacao['reportado_autoridades'] ?? null) !== 'Sim')
                                    <form action="{{ route('denuncias.report-authorities', $denuncia) }}" method="POST" onsubmit="return confirm('Confirmar envio desta denúncia para as autoridades?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning w-100">
                                            <i class="bi bi-megaphone"></i> Reportar às Autoridades
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-success mb-0 py-2 small">
                                        <i class="bi bi-check-circle"></i> Já reportada às autoridades
                                    </div>
                                @endif

                                @if(auth()->user()->isModerator())
                                    <form action="{{ route('denuncias.resolve', $denuncia) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success w-100">
                                            <i class="bi bi-check2-all"></i> Marcar Resolvido
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if(auth()->user()?->isModerator())
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rejeitar Denúncia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('denuncias.reject', $denuncia) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Motivo da Rejeição</label>
                            <textarea name="motivo" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Rejeitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
