@extends('layouts.app')

@section('title', 'Sobre - Sistema de Combate a Burlas Digitais')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Sobre a Plataforma</h1>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body p-4">
                    <h4 class="mb-3">Missão</h4>
                    <p class="text-muted">
                        O Sistema de Combate a Burlas Digitais foi desenvolvido para apoiar a prevenção, identificação
                        e denúncia de fraudes online, promovendo uma cultura de segurança digital e resposta rápida.
                    </p>

                    <h4 class="mb-3 mt-4">O que oferecemos</h4>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2">Denúncias estruturadas</div>
                                <div class="text-muted">Registo e acompanhamento de ocorrências com maior organização.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2">Educação digital</div>
                                <div class="text-muted">Cursos e conteúdos para fortalecer a prevenção contra fraudes.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2">Testador de links</div>
                                <div class="text-muted">Ferramenta para analisar URLs suspeitas antes do acesso.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2">Visão territorial</div>
                                <div class="text-muted">Mapa de denúncias para identificar padrões por localização.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h4 class="mb-3">Valores</h4>
                    <ul class="list-unstyled text-muted mb-0">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Transparência no tratamento das denúncias</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Educação como ferramenta de prevenção</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-success me-2"></i>Protecção do cidadão no ambiente digital</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i>Colaboração com utilizadores e instituições</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
