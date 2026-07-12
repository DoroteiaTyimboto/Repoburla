@extends('layouts.app')

@section('title', $curso->titulo)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="page-title">{{ $curso->titulo }}</h1>

            <div class="card mb-4">
                <div style="height: 300px; background: linear-gradient(135deg, #6c757d 0%, #343a40 100%); display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="bi bi-shield-lock" style="font-size: 5rem;"></i>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Sobre o Curso</h5>
                    <p class="card-text">{{ $curso->descricao }}</p>

                    <div class="mb-3">
                        <span class="badge bg-info">{{ ucfirst($curso->nivel) }}</span>
                        @if($curso->duracao_minutos)
                            <span class="badge bg-secondary"><i class="bi bi-clock"></i> {{ $curso->duracao_minutos }} minutos</span>
                        @endif
                        @if($curso->categoria)
                            <span class="badge bg-primary">{{ $curso->categoria }}</span>
                        @endif
                    </div>

                    <hr>

                    <h5 class="mb-3">Estatísticas</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold">{{ $totalInscritos }}</h3>
                                <small class="text-muted">Inscritos</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold">{{ $totalConcluido }}</h3>
                                <small class="text-muted">Concluído</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold">{{ $taxaConclusao }}%</h3>
                                <small class="text-muted">Taxa</small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h3 class="fw-bold">{{ $mediaAvaliacoes }}/5</h3>
                                <small class="text-muted">Avaliação</small>
                            </div>
                        </div>
                    </div>

                    @if($curso->conteudo)
                        <hr>
                        <h5>Conteúdo</h5>
                        <div class="alert alert-light">
                            @php
                                $conteudo = e($curso->conteudo);
                                $conteudo = preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $conteudo);
                                echo nl2br($conteudo);
                            @endphp
                        </div>
                    @endif
                </div>
            </div>

            <!-- Avaliações -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Avaliações</h5>
                </div>
                <div class="card-body">
                    @if(auth()->check() && $isInscrito)
                        <form action="{{ route('cursos.rate', $curso) }}" method="POST" class="mb-4">
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
                    @endif

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
                    @if(auth()->check() && $isInscrito)
                        <form action="{{ route('cursos.comment', $curso) }}" method="POST" class="mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea name="conteudo" class="form-control" rows="3" placeholder="Adicionar comentário..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Comentar</button>
                        </form>
                    @endif

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
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-body">
                    @if($isInscrito)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> Você está inscrito neste curso
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Seu Progresso</label>
                            @php $progresso = $userProgresso ?? 0; @endphp
                            <div class="progress" style="height: 25px;">
                                <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: {{ $progresso }}%" aria-valuenow="{{ $progresso }}" aria-valuemin="0" aria-valuemax="100">{{ $progresso }}%</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button id="increaseBtn" class="btn btn-outline-primary">Aumentar progresso +10%</button>
                            <button id="decreaseBtn" class="btn btn-outline-secondary">Diminuir progresso -10%</button>
                            <button id="completeBtn" class="btn btn-success">Marcar como concluído</button>
                        </div>

                        <form action="{{ route('cursos.unenroll', $curso) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="bi bi-x-circle"></i> Desinscrever
                            </button>
                        </form>
                    @else
                        @auth
                            <form action="{{ route('cursos.enroll', $curso) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100 btn-lg">
                                    <i class="bi bi-plus-circle"></i> Inscrever-se
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-login"></i> Login para Inscrever
                            </a>
                        @endauth
                    @endif

                    <hr>

                    <h6>Informações</h6>
                    <dl class="small mb-0">
                        <dt>Nível</dt>
                        <dd>{{ ucfirst($curso->nivel) }}</dd>

                        <dt>Duração</dt>
                        <dd>{{ $curso->duracao_minutos ?? 'Sem limite' }} minutos</dd>

                        <dt>Categoria</dt>
                        <dd>{{ $curso->categoria ?? 'Geral' }}</dd>

                        <dt>Inscritos</dt>
                        <dd>{{ $totalInscritos }}</dd>

                        <dt>Avaliação</dt>
                        <dd>
                            @if($mediaAvaliacoes > 0)
                                <i class="bi bi-star-fill" style="color: #f39c12;"></i> {{ $mediaAvaliacoes }}/5
                            @else
                                Sem avaliações
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    (function(){
        const progressBar = document.getElementById('progressBar');
        if(!progressBar) return;

        const url = '{{ route('cursos.progress', $curso) }}';
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function setProgress(value){
            value = Math.max(0, Math.min(100, parseInt(value)));
            progressBar.style.width = value + '%';
            progressBar.setAttribute('aria-valuenow', value);
            progressBar.textContent = value + '%';
        }

        async function sendProgress(value){
            try{
                const res = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ progresso: value })
                });
                const data = await res.json();
                if(data.success){
                    setProgress(value);
                } else {
                    alert('Não foi possível atualizar o progresso.');
                }
            } catch(e) {
                console.error(e);
                alert('Erro ao atualizar progresso.');
            }
        }

        document.getElementById('increaseBtn').addEventListener('click', function(e){
            e.preventDefault();
            const cur = parseInt(progressBar.getAttribute('aria-valuenow') || 0);
            const next = Math.min(100, cur + 10);
            sendProgress(next);
        });

        document.getElementById('decreaseBtn').addEventListener('click', function(e){
            e.preventDefault();
            const cur = parseInt(progressBar.getAttribute('aria-valuenow') || 0);
            const next = Math.max(0, cur - 10);
            sendProgress(next);
        });

        document.getElementById('completeBtn').addEventListener('click', function(e){
            e.preventDefault();
            sendProgress(100);
        });
    })();
</script>
@endsection