@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ Auth::user()->profile_photo ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&size=200' }}" 
                     class="rounded-circle mb-3" width="150" height="150" alt="Foto de perfil">
                <h3>{{ Auth::user()->name }}</h3>
                <p class="text-muted">{{ Auth::user()->email }}</p>
                <p>
                    <span class="badge bg-{{ Auth::user()->type === 'admin' ? 'danger' : (Auth::user()->type === 'gerente' ? 'warning' : 'primary') }}">
                        {{ ucfirst(Auth::user()->type) }}
                    </span>
                </p>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary btn-sm">Editar Perfil</a>
                @if(!Auth::user()->hasExtendedProfile())
                    <a href="{{ route('profile.extended') }}" class="btn btn-outline-secondary btn-sm">Completar Perfil</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Minhas Atividades</h4>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="ratings-tab" data-bs-toggle="tab" data-bs-target="#ratings" type="button" role="tab">Avaliações</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#events" type="button" role="tab">Eventos</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="trades-tab" data-bs-toggle="tab" data-bs-target="#trades" type="button" role="tab">Trocas</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="ratings" role="tabpanel">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Música</th>
                                    <th>Grupo</th>
                                    <th>Avaliação</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ratings as $rating)
                                    <tr>
                                        <td>{{ $rating->music->title }}</td>
                                        <td>{{ $rating->music->group->name }}</td>
                                        <td>
                                            @include('components.rating-stars', ['rating' => $rating->rating])
                                        </td>
                                        <td>{{ $rating->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Nenhuma avaliação ainda</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="events" role="tabpanel">
                        <div class="list-group">
                            @forelse($participatedEvents as $event)
                                <a href="{{ route('events.show', $event->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $event->name }}</h5>
                                        <small>{{ $event->date_event->format('d/m/Y') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $event->location }}</p>
                                    <small>Status: {{ ucfirst($event->status) }}</small>
                                </a>
                            @empty
                                <div class="list-group-item">Nenhum evento participado</div>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane fade" id="trades" role="tabpanel">
                        <div class="list-group">
                            @forelse($trades as $trade)
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Troca #{{ $trade->id }}</h5>
                                        <span class="badge bg-{{ $trade->status === 'pending' ? 'warning' : ($trade->status === 'completed' ? 'success' : 'secondary') }}">
                                            {{ ucfirst($trade->status) }}
                                        </span>
                                    </div>
                                    <p class="mb-1">Você {{ $trade->sender_id === Auth::id() ? 'ofereceu' : 'recebeu' }}: {{ $trade->offered_item }}</p>
                                    <p class="mb-1">Por: {{ $trade->requested_item }}</p>
                                    <small>Data: {{ $trade->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            @empty
                                <div class="list-group-item">Nenhuma troca realizada</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection