@extends('layouts.app')
@section('title', 'Líneas')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-route me-2 text-primary"></i>Líneas</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Líneas</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('lineas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nueva Línea
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
                        <th>Distancia (km)</th>
                        <th>Estaciones</th>
                        <th>Buses</th>
                        <th>Estado Mínimo</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($lineas as $linea)
                <tr>
                    <td class="text-muted small">{{ $linea->id }}</td>
                    <td class="fw-semibold">{{ $linea->nombre }}</td>
                    <td>{{ $linea->municipalidad->nombre }}</td>
                    <td>{{ number_format($linea->distancia_total, 1) }} km</td>
                    <td>
                        <span class="badge bg-secondary">{{ $linea->estaciones->count() }}</span>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $linea->buses->count() }}</span>
                    </td>
                    <td>
                        @if($linea->cumpleMinimoBuses())
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>OK</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-xmark me-1"></i>Insuficiente</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('lineas.show', $linea) }}" class="btn btn-sm btn-outline-info" title="Ver detalle">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->esAdmin())
                        <a href="{{ route('lineas.edit', $linea) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form method="POST" action="{{ route('lineas.destroy', $linea) }}" class="d-inline"
                              onsubmit="return confirm('¿Eliminar la línea {{ addslashes($linea->nombre) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="fas fa-route fa-2x mb-2 d-block"></i>No hay líneas registradas.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
