@extends('layouts.app')
@section('title', 'Nueva Línea')

@section('content')
<div class="page-header">
    <h4 class="mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Nueva Línea</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('lineas.index') }}">Líneas</a></li>
            <li class="breadcrumb-item active">Nueva</li>
        </ol>
    </nav>
</div>

<div class="card shadow-sm border-0" style="max-width:760px">
    <div class="card-body">
        <form method="POST" action="{{ route('lineas.store') }}">
            @csrf
            @include('lineas._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar Línea
                </button>
                <a href="{{ route('lineas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
