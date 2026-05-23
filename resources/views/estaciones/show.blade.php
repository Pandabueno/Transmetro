@extends('layouts.app')
@section('title', $estacion->nombre)

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-map-pin me-2 text-success"></i>{{ $estacion->nombre }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('estaciones.index') }}">Estaciones</a></li>
                <li class="breadcrumb-item active">{{ $estacion->nombre }}</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('estaciones.edit', $estacion) }}" class="btn btn-warning">
        <i class="fas fa-pen me-1"></i> Editar
    </a>
    @endif
</div>

@php
    $pct   = $estacion->porcentajeOcupacion();
    $color = $pct >= 90 ? 'danger' : ($pct >= 75 ? 'warning' : ($pct >= 50 ? 'info' : 'success'));
@endphp

<div class="row g-3">
    {{-- Info + ocupación --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header fw-semibold bg-white">Información</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="text-muted small">Municipalidad</dt>
                    <dd class="fw-semibold">{{ $estacion->municipalidad->nombre }}</dd>
                    <dt class="text-muted small">Ocupación</dt>
                    <dd>
                        <span class="fw-bold">{{ $estacion->ocupacion_actual }}</span>
                        / {{ $estacion->capacidad_maxima }}
                    </dd>
                </dl>
                <div class="progress mt-2" style="height:12px">
                    <div class="progress-bar bg-{{ $color }} progress-bar-striped" style="width:{{ $pct }}%"></div>
                </div>
                <div class="text-end mt-1">
                    <span class="badge bg-{{ $color }}">{{ $pct }}%</span>
                </div>
                <dt class="text-muted small mt-2">Líneas</dt>
                @forelse($estacion->lineas as $l)
                    <span class="badge bg-primary me-1">{{ $l->nombre }}</span>
                @empty
                    <span class="text-muted small">Ninguna</span>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Accesos y parqueos --}}
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header fw-semibold bg-white">
                        <i class="fas fa-door-open me-1 text-secondary"></i> Accesos ({{ $estacion->accesos->count() }})
                    </div>
                    @if($estacion->accesos->isEmpty())
                        <div class="card-body text-muted small">Sin accesos registrados.</div>
                    @else
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr><th>Descripción</th><th>Guardia</th><th>Teléfono</th></tr>
                                </thead>
                                <tbody>
                                @foreach($estacion->accesos as $acc)
                                <tr>
                                    <td>{{ $acc->descripcion }}</td>
                                    <td>{{ $acc->guardia?->nombre ?? '—' }}</td>
                                    <td>{{ $acc->guardia?->telefono ?? '—' }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header fw-semibold bg-white">
                        <i class="fas fa-square-parking me-1 text-info"></i> Parqueos ({{ $estacion->parqueos->count() }})
                    </div>
                    @if($estacion->parqueos->isEmpty())
                        <div class="card-body text-muted small">Sin parqueos registrados.</div>
                    @else
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr><th>Nombre</th><th>Capacidad</th></tr>
                                </thead>
                                <tbody>
                                @foreach($estacion->parqueos as $par)
                                <tr>
                                    <td>{{ $par->nombre }}</td>
                                    <td>{{ $par->capacidad }} vehículos</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @if($estacion->alertas->isNotEmpty())
            <div class="col-12">
                <div class="card shadow-sm border-0 border-danger border-opacity-25">
                    <div class="card-header fw-semibold bg-white">
                        <i class="fas fa-bell me-1 text-danger"></i> Últimas Alertas
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0 small">
                                <thead class="table-light">
                                    <tr><th>Tipo</th><th>Fecha/Hora</th><th>Estado</th></tr>
                                </thead>
                                <tbody>
                                @foreach($estacion->alertas as $al)
                                <tr>
                                    <td>{{ ucfirst($al->tipo) }}</td>
                                    <td>{{ $al->fecha_hora->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $al->atendida ? 'bg-success' : 'bg-danger' }}">
                                            {{ $al->atendida ? 'Atendida' : 'Pendiente' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
