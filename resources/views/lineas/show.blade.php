@extends('layouts.app')
@section('title', $linea->nombre)

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-route me-2 text-primary"></i>{{ $linea->nombre }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('lineas.index') }}">Líneas</a></li>
                <li class="breadcrumb-item active">{{ $linea->nombre }}</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('lineas.edit', $linea) }}" class="btn btn-warning">
        <i class="fas fa-pen me-1"></i> Editar
    </a>
    @endif
</div>

<div class="row g-3">
    {{-- Info general --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header fw-semibold bg-white">Información General</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="text-muted small">Municipalidad</dt>
                    <dd class="fw-semibold">{{ $linea->municipalidad->nombre }}</dd>
                    <dt class="text-muted small">Distancia Total</dt>
                    <dd class="fw-semibold">{{ number_format($linea->distancia_total, 1) }} km</dd>
                    <dt class="text-muted small">Buses Asignados</dt>
                    <dd>
                        <span class="badge bg-info fs-6">{{ $linea->buses->count() }}</span>
                        @if(!$linea->cumpleMinimoBuses())
                            <span class="badge bg-danger ms-1">Insuficientes</span>
                        @endif
                    </dd>
                    <dt class="text-muted small">Límite de Buses</dt>
                    <dd>{{ $linea->estaciones->count() * 2 }}</dd>
                </dl>
            </div>
        </div>
    </div>

    {{-- Estaciones --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header fw-semibold bg-white">
                <i class="fas fa-map-pin me-1 text-primary"></i> Estaciones ({{ $linea->estaciones->count() }})
            </div>
            <div class="card-body p-0">
                @if($linea->estaciones->isEmpty())
                    <p class="text-muted text-center py-4">Sin estaciones asignadas.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light"><tr><th>Orden</th><th>Estación</th><th>Distancia acum.</th></tr></thead>
                        <tbody>
                        @foreach($linea->estaciones as $est)
                        <tr>
                            <td><span class="badge bg-primary">{{ $est->pivot->orden }}</span></td>
                            <td class="fw-semibold">{{ $est->nombre }}</td>
                            <td>{{ number_format($est->pivot->distancia, 1) }} km</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>

        {{-- Buses --}}
        @if($linea->buses->isNotEmpty())
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-header fw-semibold bg-white">
                <i class="fas fa-bus me-1 text-info"></i> Buses Asignados
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light"><tr><th>Placa</th><th>Capacidad</th><th>Piloto</th></tr></thead>
                        <tbody>
                        @foreach($linea->buses as $bus)
                        <tr>
                            <td class="fw-semibold">{{ $bus->placa }}</td>
                            <td>{{ $bus->capacidad_max }} pax</td>
                            <td>{{ $bus->piloto?->nombre ?? '—' }}</td>
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
