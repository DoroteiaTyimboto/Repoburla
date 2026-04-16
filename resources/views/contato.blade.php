@extends('layouts.app')

@section('title', 'Contacto - Sistema de Combate a Burlas Digitais')

@section('content')
<div class="container py-4">
    <h1 class="page-title">Contacto</h1>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h4 class="mb-3">Fale com a nossa equipa</h4>
                    <p class="text-muted mb-4">
                        Estamos disponíveis para apoiar utilizadores, receber sugestões e esclarecer dúvidas sobre denúncias,
                        cursos e segurança digital.
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2"><i class="bi bi-envelope-fill me-2"></i>Email</div>
                                <div class="text-muted">suporte@burlasdigitais.ao</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2"><i class="bi bi-telephone-fill me-2"></i>Telefone</div>
                                <div class="text-muted">+244 900 000 000</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Endereço</div>
                                <div class="text-muted">Luanda, Angola</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border rounded p-3 h-100">
                                <div class="fw-bold mb-2"><i class="bi bi-clock-fill me-2"></i>Horário</div>
                                <div class="text-muted">Segunda a Sexta, 8h00 às 17h00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h4 class="mb-3">Canais de atendimento</h4>
                    <p class="text-muted mb-4">
                        Escolha o canal mais adequado para entrar em contacto connosco.
                    </p>

                    <div class="d-grid gap-3">
                        <a href="mailto:suporte@burlasdigitais.ao" class="btn btn-primary">
                            <i class="bi bi-envelope me-2"></i>Enviar Email
                        </a>
                        <a href="tel:+244900000000" class="btn btn-outline-primary">
                            <i class="bi bi-telephone me-2"></i>Ligar Agora
                        </a>
                        <a href="{{ route('mapa') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-geo-alt me-2"></i>Ver Mapa de Denúncias
                        </a>
                    </div>

                    <div class="alert alert-info mt-4 mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Para denúncias urgentes, utilize também os canais oficiais das autoridades competentes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
