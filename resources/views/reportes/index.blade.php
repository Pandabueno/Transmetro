@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
<div class="page-header">
    <h4 class="mb-0"><i class="fas fa-file-chart-column me-2 text-primary"></i>Módulo de Reportes</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Reportes</li>
        </ol>
    </nav>
</div>

<div class="row g-4">

    {{-- RF-19 --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle"
                         style="width:64px;height:64px;font-size:1.8rem">
                        <i class="fas fa-bus"></i>
                    </div>
                </div>
                <h5 class="fw-bold">RF-19</h5>
                <p class="text-muted small mb-4">
                    Buses asignados por línea con estado de cumplimiento de mínimos operativos.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('reportes.rf19') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i> Ver
                    </a>
                    <a href="{{ route('reportes.rf19.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- RF-20 --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger bg-opacity-10 text-danger rounded-circle"
                         style="width:64px;height:64px;font-size:1.8rem">
                        <i class="fas fa-bell"></i>
                    </div>
                </div>
                <h5 class="fw-bold">RF-20</h5>
                <p class="text-muted small mb-4">
                    Alertas de ocupación generadas por estación — historial completo con estado de atención.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('reportes.rf20') }}" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-eye me-1"></i> Ver
                    </a>
                    <a href="{{ route('reportes.rf20.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- RF-21 --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-circle"
                         style="width:64px;height:64px;font-size:1.8rem">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <h5 class="fw-bold">RF-21</h5>
                <p class="text-muted small mb-4">
                    Tiempos de espera de buses por estación — promedio, máximo y detalle por registro.
                </p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('reportes.rf21') }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-eye me-1"></i> Ver
                    </a>
                    <a href="{{ route('reportes.rf21.pdf') }}" class="btn btn-danger btn-sm">
                        <i class="fas fa-file-pdf me-1"></i> PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
