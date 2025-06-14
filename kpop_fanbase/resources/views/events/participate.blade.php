@extends('layouts.app')

@section('title', 'Confirmar Presença: ' . $event->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Confirmar Presença</h4>
                </div>
                <div class="card-body">
                    @if($event->is_full)
                        <div class="alert alert-danger">
                            Este evento já está lotado!
                        </div>
                    @elseif($alreadyParticipating)
                        <div class="alert alert-info">
                            Você já confirmou presença neste evento.
                        </div>
                    @else
                        <div class="text-center mb-4">
                            <h5>{{ $event->name }}</h5>
                            <p><i class="fas fa-calendar-alt me-2"></i> {{ $event->date_event->format('d/m/Y H:i') }}</p>
                            <p><i class="fas fa-map-marker-alt me-2"></i> {{ $event->location }}</p>
                            <p><i class="fas fa-users me-2"></i> Vagas restantes: {{ $event->capacity - $event->participants_count }}</p>
                        </div>
                        
                        <form method="POST" action="{{ route('events.participate', $event->id) }}">
                            @csrf
                            
                            @if($event->price > 0)
                                <div class="mb-3">
                                    <label for="payment_method" class="form-label">Método de Pagamento</label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="">Selecione...</option>
                                        <option value="credit_card">Cartão de Crédito</option>
                                        <option value="debit_card">Cartão de Débito</option>
                                        <option value="pix">PIX</option>
                                        <option value="bank_slip">Boleto Bancário</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="alert alert-info">
                                    Valor: R$ {{ number_format($event->price, 2) }}
                                </div>
                            @endif
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Confirmar Presença</button>
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">Voltar</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection