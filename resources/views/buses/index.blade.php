@extends('layouts.app')
@section('title', 'Buses')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-bus me-2 text-info"></i>Buses</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Buses</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('buses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nuevo Bus
    </a>
    @endif
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Placa</th>
                        <th>Capacidad</th>
                        <th>Línea</th>
                        <th>Parqueo</th>
                        <th>Piloto</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($buses as $bus)
                <tr>
                    <td class="fw-semibold font-monospace">{{ $bus->placa }}</td>
                    <td>{{ $bus->capacidad_max }} pax</td>
                    <td>
                        @if($bus->linea)
                            <span class="badge bg-primary">{{ $bus->linea->nombre }}</span>
                        @else
                            <span class="text-muted small">Sin asignar</span>
                        @endif
                    </td>
                    <td>{{ $bus->parqueo?->nombre ?? '—' }}</td>
                    <td>{{ $bus->piloto?->nombre ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('buses.show', $bus) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->esAdmin())
                        <a href="{{ route('buses.edit', $bus) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form method="POST" action="{{ route('buses.destroy', $bus) }}" class="d-inline"
                              onsubmit="return confirm('¿Eliminar bus {{ $bus->placa }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Sin buses registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
