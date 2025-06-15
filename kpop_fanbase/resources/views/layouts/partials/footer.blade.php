<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>KPOP FanBase Manager</h5>
                <p>Sua plataforma completa para gerenciar sua paixão por K-POP.</p>
            </div>
            <div class="col-md-4">
                <h5>Links Rápidos</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white">Home</a></li>
                    <li><a href="{{ route('sobre') }}" class="text-white">Sobre</a></li>
                    <li><a href="{{ route('grupos.index') }}" class="text-white">Grupos</a></li>
                    <li><a href="{{ route('eventos.index') }}" class="text-white">Eventos</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contato</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-envelope"></i> contato@kpopfanbase.com</li>
                    <li><i class="fas fa-phone"></i> (00) 0000-0000</li>
                </ul>
                <div class="social-icons">
                    <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <p class="mb-0">&copy; {{ date('Y') }} KPOP FanBase Manager. Todos os direitos reservados.</p>
        </div>
    </div>
</footer>