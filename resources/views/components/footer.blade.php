<footer>
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-4 mb-4">
                <h5 class="mb-3">
                    <i class="bi bi-shield-check"></i> Burlas Digitais
                </h5>
                <p>Sistema completo para combater fraudes e burlas digitais com educação e segurança.</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Links Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Início</a></li>
                    <li><a href="{{ route('denuncias.index') }}" class="text-white-50 text-decoration-none">Denúncias</a></li>
                    <li><a href="{{ route('cursos.index') }}" class="text-white-50 text-decoration-none">Cursos</a></li>
                    <li><a href="{{ route('testador.index') }}" class="text-white-50 text-decoration-none">Testador de Links</a></li>
                    <li><a href="{{ route('sobre') }}" class="text-white-50 text-decoration-none">Sobre</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="mb-3">Redes Sociais</h5>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50 text-decoration-none fs-5"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none fs-5"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none fs-5"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none fs-5"><i class="bi bi-instagram"></i></a>
                </div>
            </div>
        </div>

        <hr class="bg-white-50">

        <div class="row">
            <div class="col-md-6 text-center text-md-start text-white-50 small">
                © 2024 Sistema de Combate a Burlas Digitais. Todos os direitos reservados.
            </div>
            <div class="col-md-6 text-center text-md-end text-white-50 small">
                <a href="{{ route('contato') }}" class="text-white-50 text-decoration-none">Contato</a> | 
                <a href="#" class="text-white-50 text-decoration-none">Política de Privacidade</a> | 
                <a href="#" class="text-white-50 text-decoration-none">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>
