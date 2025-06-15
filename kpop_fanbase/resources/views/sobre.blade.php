@extends('layouts.app', ['title' => 'Sobre'])

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h2><i class="fas fa-info-circle"></i> Sobre o KPOP FanBase Manager</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3>Nossa Missão</h3>
                <p>O KPOP FanBase Manager foi criado para unir fãs de K-POP em uma plataforma onde podem compartilhar sua paixão, gerenciar suas coleções, participar de eventos e interagir com outros fãs.</p>
                
                <h3 class="mt-4">Recursos Principais</h3>
                <ul>
                    <li>Catálogo completo de grupos e músicas de K-POP</li>
                    <li>Sistema de avaliação de músicas</li>
                    <li>Gerenciamento de itens colecionáveis</li>
                    <li>Sistema de trocas entre fãs</li>
                    <li>Criação e participação em eventos</li>
                    <li>Recomendações personalizadas</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h3>Nossa Equipe</h3>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://via.placeholder.com/150" class="img-fluid rounded-start" alt="Equipe">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">Time KPOP FanBase</h5>
                                <p class="card-text">Somos um grupo de desenvolvedores e fãs de K-POP dedicados a criar a melhor plataforma para a comunidade.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h3 class="mt-4">Contato</h3>
                <p><i class="fas fa-envelope"></i> contato@kpopfanbase.com</p>
                <p><i class="fas fa-phone"></i> (00) 0000-0000</p>
            </div>
        </div>
    </div>
</div>
@endsection