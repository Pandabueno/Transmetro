@extends('layouts.app')
@section('title', 'Bus ' . $bus->placa)

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-bus me-2 text-info"></i>Bus {{ $bus->placa }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('buses.index') }}">Buses</a></li>
                <li class="breadcrumb-item active">{{ $bus->placa }}</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('buses.edit', $bus) }}" class="btn btn-warning">
        <i class="fas fa-pen me-1"></i> Editar
    </a>
    @endif
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header fw-semibold bg-white">Información del Bus</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="text-muted small">Placa</dt>
                    <dd class="fw-bold font-monospace fs-5">{{ $bus->placa }}</dd>
                    <dt class="text-muted small">Capacidad</dt>
                    <dd>{{ $bus->capacidad_max }} pasajeros</dd>
                    <dt class="text-muted small">Línea</dt>
                    <dd>
                        @if($bus->linea)
                            <span class="badge bg-primary">{{ $bus->linea->nombre }}</span>
                        @else
                            <span class="text-muted">Sin asignar</span>
                        @endif
                    </dd>
                    <dt class="text-muted small">Parqueo</dt>
                    <dd>{{ $bus->parqueo?->nombre ?? '—' }}</dd>
                </dl>
            </div>
        </div>

        @if($bus->piloto)
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header fw-semibold bg-white">
                <i class="fas fa-id-card me-1 text-secondary"></i> Piloto
            </div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="text-muted small">Nombre</dt>
                    <dd class="fw-semibold">{{ $bus->piloto->nombre }}</dd>
                    <dt class="text-muted small">Teléfono</dt>
                    <dd>{{ $bus->piloto->telefono }}</dd>
                    <dt class="text-muted small">Email</dt>
                    <dd class="small">{{ $bus->piloto->email }}</dd>
                </dl>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-8">
        @if($bus->registroEsperas->isNotEmpty())
        <div class="card shadow-sm border-0">
            <div class="card-header fw-semibold bg-white">
                <i class="fas fa-clock me-1 text-info"></i> Últimos Registros de Espera
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0 small">
                        <thead class="table-light">
                            <tr><th>Estación</th><th>Espera</th><th>Fecha/Hora</th></tr>
                        </thead>
                        <tbody>
                        @foreach($bus->registroEsperas as $re)
                        <tr>
                            <td>{{ $re->estacion->nombre }}</td>
                            <td>
                                <span class="badge {{ $re->minutos_espera >= 10 ? 'bg-danger' : ($re->minutos_espera >= 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                                    {{ $re->minutos_espera }} min
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($re->fecha_hora)->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
