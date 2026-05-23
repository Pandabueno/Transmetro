@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- ── Page Header ── --}}
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Dashboard</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Inicio</li>
            </ol>
        </nav>
    </div>
    <small class="text-muted">
        <i class="fas fa-clock me-1"></i>Actualizado {{ now()->format('d/m/Y H:i') }}
    </small>
</div>

{{-- ── Tarjetas resumen ── --}}
<div class="row g-3 mb-4">

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-route"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-primary">{{ $stats['lineas'] }}</div>
                    <div class="text-muted small">Líneas</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-map-pin"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-success">{{ $stats['estaciones'] }}</div>
                    <div class="text-muted small">Estaciones</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info">
                    <i class="fas fa-bus"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-info">{{ $stats['buses'] }}</div>
                    <div class="text-muted small">Buses</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-md-4 col-xl-2">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                    <i class="fas fa-id-card"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-secondary">{{ $stats['pilotos'] }}</div>
                    <div class="text-muted small">Pilotos</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-4 col-xl-4">
        <div class="card stat-card h-100 border-danger border-opacity-25">
            <div class="card-body d-flex align-items-center gap-3 p-3">
                <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-bell"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-danger">{{ $stats['alertas'] }}</div>
                    <div class="text-muted small">Alertas Pendientes</div>
                </div>
                @if($stats['alertas'] > 0)
                <a href="{{ route('alertas.index') }}" class="btn btn-sm btn-outline-danger ms-auto">
                    Ver <i class="fas fa-arrow-right ms-1"></i>
                </a>
                @endif
            </div>
        </div>
    </div>

</div>

<div class="row g-3">

    {{-- ── Alertas pendientes ── --}}
    <div class="col-12 col-xl-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-bell text-danger me-2"></i>Alertas Pendientes
                </h6>
                <a href="{{ route('alertas.index') }}" class="btn btn-sm btn-outline-secondary">
                    Ver todas
                </a>
            </div>
            <div class="card-body p-0">
                @if($alertas->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        Sin alertas pendientes
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Estación</th>
                                <th>Tipo</th>
                                <th>Fecha/Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($alertas as $a)
                        <tr>
                            <td class="fw-semibold">{{ $a->estacion->nombre }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ ucfirst($a->tipo) }}
                                </span>
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($a->fecha_hora)->format('d/m H:i') }}
                            </td>
                            <td>
                                <span class="badge bg-danger">Pendiente</span>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Registros de espera ── --}}
    <div class="col-12 col-xl-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-clock text-info me-2"></i>Últimos Registros de Espera
                </h6>
            </div>
            <div class="card-body p-0">
                @if($esperas->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                        Sin registros
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Bus</th>
                                <th>Estación</th>
                                <th>Espera</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($esperas as $e)
                        <tr>
                            <td class="fw-semibold">{{ $e->bus->placa }}</td>
                            <td>{{ $e->estacion->nombre }}</td>
                            <td>
                                <span class="badge {{ $e->minutos_espera >= 10 ? 'bg-danger' : ($e->minutos_espera >= 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                                    {{ $e->minutos_espera }} min
                                </span>
                            </td>
                            <td class="text-muted">
                                {{ \Carbon\Carbon::parse($e->fecha_hora)->format('d/m H:i') }}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Estaciones críticas ── --}}
    @if($estacionesCriticas->isNotEmpty())
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="fas fa-triangle-exclamation text-warning me-2"></i>Estaciones con Alta Ocupación (≥ 75 %)
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th>Estación</th>
                                <th>Ocupación</th>
                                <th>Capacidad</th>
                                <th style="width:200px">Nivel</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($estacionesCriticas as $est)
                        @php
                            $pct = $est->capacidad_maxima > 0
                                ? round($est->ocupacion_actual / $est->capacidad_maxima * 100)
                                : 0;
                            $color = $pct >= 90 ? 'danger' : ($pct >= 75 ? 'warning' : 'success');
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $est->nombre }}</td>
                            <td>{{ $est->ocupacion_actual }}</td>
                            <td>{{ $est->capacidad_maxima }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress flex-grow-1" style="height:8px">
                                        <div class="progress-bar bg-{{ $color }}" style="width:{{ $pct }}%"></div>
                                    </div>
                                    <span class="badge bg-{{ $color }}">{{ $pct }}%</span>
                                </div>
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
@endsection
