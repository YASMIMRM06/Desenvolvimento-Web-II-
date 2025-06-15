<header class="bg-dark text-white">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-star"></i> KPOP FanBase
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('grupos.index') }}">Grupos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('musicas.index') }}">Músicas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('eventos.index') }}">Eventos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('itens.index') }}">Minha Coleção</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('trocas.index') }}">Trocas</a>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle"></i> {{ Auth::user()->nome }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">Meu Perfil</a></li>
                                    @if(Auth::user()->isAdmin())
                                        <li><a class="dropdown-item" href="{{ route('users.index') }}">Gerenciar Usuários</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Sair</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Cadastrar</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>