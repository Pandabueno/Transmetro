@extends('layouts.app')
@section('title', 'Pilotos')

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4 class="mb-0"><i class="fas fa-id-card me-2 text-secondary"></i>Pilotos</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 small">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pilotos</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->esAdmin())
    <a href="{{ route('pilotos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Nuevo Piloto
    </a>
    @endif
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Bus</th>
                        <th>Línea</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($pilotos as $piloto)
                <tr>
                    <td class="fw-semibold">{{ $piloto->nombre }}</td>
                    <td>{{ $piloto->telefono }}</td>
                    <td class="small">{{ $piloto->email }}</td>
                    <td>
                        @if($piloto->bus)
                            <span class="badge bg-info font-monospace">{{ $piloto->bus->placa }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td>
                        @if($piloto->bus?->linea)
                            <span class="badge bg-primary">{{ $piloto->bus->linea->nombre }}</span>
                        @else
                            <span class="text-muted small">—</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('pilotos.show', $piloto) }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if(auth()->user()->esAdmin())
                        <a href="{{ route('pilotos.edit', $piloto) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-pen"></i>
                        </a>
                        <form method="POST" action="{{ route('pilotos.destroy', $piloto) }}" class="d-inline"
                              onsubmit="return confirm('¿Eliminar piloto {{ addslashes($piloto->nombre) }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-5">Sin pilotos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
