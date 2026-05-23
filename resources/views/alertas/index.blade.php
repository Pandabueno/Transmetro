@extends('layouts.app')
@section('title', 'Alertas')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-bell me-2 text-danger"></i>Panel de Alertas</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Alertas</li>
            </ol>
        </nav>
    </div>
    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEspera">
        <i class="fas fa-clock me-1"></i> Registrar Espera de Bus
    </button>
</div>

{{-- Resumen rápido --}}
@php
    $pendientes = $alertas->where('atendida', false)->count();
    $atendidas  = $alertas->where('atendida', true)->count();
@endphp
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-danger">{{ $alertas->total() }}</div>
            <div class="text-muted small">Total en página</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-warning">{{ $pendientes }}</div>
            <div class="text-muted small">Pendientes</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-success">{{ $atendidas }}</div>
            <div class="text-muted small">Atendidas</div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Estación</th>
                        <th>Tipo</th>
                        <th>Fecha/Hora</th>
                        <th>Estado</th>
                        <th>Atendida por</th>
                        <th class="text-end">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($alertas as $alerta)
                <tr class="{{ !$alerta->atendida ? 'table-warning bg-opacity-25' : '' }}">
                    <td class="text-muted small">{{ $alerta->id }}</td>
                    <td class="fw-semibold">{{ $alerta->estacion->nombre }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($alerta->tipo) }}</span></td>
                    <td>{{ $alerta->fecha_hora->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($alerta->atendida)
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Atendida</span>
                        @else
                            <span class="badge bg-danger"><i class="fas fa-clock me-1"></i>Pendiente</span>
                        @endif
                    </td>
                    <td>{{ $alerta->operadorAtencion?->nombre ?? '—' }}</td>
                    <td class="text-end">
                        @if(!$alerta->atendida)
                        <form method="POST" action="{{ route('alertas.atender', $alerta) }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check me-1"></i> Atender
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                        No hay alertas registradas.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($alertas->hasPages())
    <div class="card-footer bg-white">
        {{ $alertas->links() }}
    </div>
    @endif
</div>

{{-- Modal Registro de Espera de Bus --}}
<div class="modal fade" id="modalEspera" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-clock me-1 text-primary"></i> Registrar Espera de Bus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('alertas.registrar-espera') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Bus <span class="text-danger">*</span></label>
                        <select name="bus_id" class="form-select" required>
                            <option value="">— Seleccione bus —</option>
                            @foreach($buses as $bus)
                            <option value="{{ $bus->id }}">
                                {{ $bus->placa }} {{ $bus->linea ? '— ' . $bus->linea->nombre : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Estación <span class="text-danger">*</span></label>
                        <select name="estacion_id" class="form-select" required>
                            <option value="">— Seleccione estación —</option>
                            @foreach($estaciones as $est)
                            <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Minutos de espera <span class="text-danger">*</span></label>
                        <input type="number" name="minutos_espera" class="form-control" min="1" max="120" placeholder="5" required>
                        <div class="form-text">Máximo 120 minutos.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Guardar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
