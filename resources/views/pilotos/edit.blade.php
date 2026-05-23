@extends('layouts.app')
@section('title', 'Editar Piloto')

@section('content')
<div class="page-header">
    <h4 class="mb-0"><i class="fas fa-pen me-2 text-warning"></i>Editar Piloto</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pilotos.index') }}">Pilotos</a></li>
            <li class="breadcrumb-item active">{{ $piloto->nombre }}</li>
        </ol>
    </nav>
</div>
<div class="card shadow-sm border-0" style="max-width:780px">
    <div class="card-body">
        <form method="POST" action="{{ route('pilotos.update', $piloto) }}">
            @csrf @method('PUT')
            @include('pilotos._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Actualizar</button>
                <a href="{{ route('pilotos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
