@extends('layouts.app')
@section('title', $piloto->nombre)

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-id-card me-2 text-secondary"></i>{{ $piloto->nombre }}</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pilotos.index') }}">Pilotos</a></li>
                <li class="breadcrumb-item active">{{ $piloto->nombre }}</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('pilotos.edit', $piloto) }}" class="btn btn-warning">
        <i class="fas fa-pen me-1"></i> Editar
    </a>
    @endif
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header fw-semibold bg-white">Datos Personales</div>
            <div class="card-body">
                <dl class="mb-0">
                    <dt class="text-muted small">Nombre</dt>
                    <dd class="fw-semibold">{{ $piloto->nombre }}</dd>
                    <dt class="text-muted small">Teléfono</dt>
                    <dd>{{ $piloto->telefono }}</dd>
                    <dt class="text-muted small">Email</dt>
                    <dd class="small">{{ $piloto->email }}</dd>
                    <dt class="text-muted small">Dirección</dt>
                    <dd class="small">{{ $piloto->direccion }}</dd>
                    <dt class="text-muted small">Bus Asignado</dt>
                    <dd>
                        @if($piloto->bus)
                            <span class="badge bg-info font-monospace">{{ $piloto->bus->placa }}</span>
                            @if($piloto->bus->linea)
                                <span class="badge bg-primary ms-1">{{ $piloto->bus->linea->nombre }}</span>
                            @endif
                        @else
                            <span class="text-muted">Sin bus</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header fw-semibold bg-white">
                <i class="fas fa-graduation-cap me-1 text-primary"></i>
                Historial Educativo ({{ $piloto->historialEducativo->count() }})
            </div>
            @if($piloto->historialEducativo->isEmpty())
                <div class="card-body text-muted">Sin historial educativo registrado.</div>
            @else
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr><th>Institución</th><th>Título</th><th>Año</th></tr>
                        </thead>
                        <tbody>
                        @foreach($piloto->historialEducativo->sortByDesc('anio_graduacion') as $h)
                        <tr>
                            <td class="fw-semibold">{{ $h->institucion }}</td>
                            <td>{{ $h->titulo }}</td>
                            <td><span class="badge bg-secondary">{{ $h->anio_graduacion }}</span></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
