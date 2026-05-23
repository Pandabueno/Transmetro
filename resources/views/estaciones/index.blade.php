@extends('layouts.app')
@section('title', 'Estaciones')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-map-pin me-2 text-success"></i>Estaciones</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Estaciones</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('estaciones.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nueva Estación
    </a>
    @endif
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Municipalidad</th>
                        <th>Ocupación</th>
                        <th>Nivel</th>
                        <th>Accesos</th>
                        <th>Parqueos</th>
                        <th>Alertas</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($estaciones as $est)
                @php
                    $pct = $est->porcentajeOcupacion();
                    $color = $pct >= 90 ? 'danger' : ($pct >= 75 ? 'warning' : ($pct >= 50 ? 'info' : 'success'));
                @endphp
                <tr>
                    <td class="text-muted small">{{ $est->id }}</td>
                    <td class="fw-semibold">{{ $est->nombre }}</td>
                    <td>{{ $est->municipalidad->nombre }}</td>
                    <td>{{ $est->ocupacion_actual }} / {{ $est->capacidad_maxima }}</td>
                    <td style="min-width:140px">
                        <div class="d-flex align-items-center gap-2">
                            <div class="progress flex-grow-1" style="height:7px">
                                <div class="progress-bar bg-{{ $color }}" style="width:{{ $pct }}%"></div>
                            </div>
                            <small class="text-{{ $color }} fw-semibold">{{ $pct }}%</small>
                        </div>
                    </td>
                    <td><span class="badge bg-secondary">{{ $est->accesos->count() }}</span></td>
                    <td><span class="badge bg-secondary">{{ $est->parqueos->count() }}</span></td>
                    <td>
                        @if($est->alertas->count() > 0)
                            <span class="badge bg-danger">{{ $est->alertas->count() }}</span>
                        @else
                            <span class="badge bg-light text-muted">0</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('estaciones.show', $est) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->esAdmin())
                        <a href="{{ route('estaciones.edit', $est) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form method="POST" action="{{ route('estaciones.destroy', $est) }}" class="d-inline"
                              onsubmit="return confirm('¿Eliminar estación {{ addslashes($est->nombre) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-5">Sin estaciones registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
