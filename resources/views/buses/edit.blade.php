@extends('layouts.app')
@section('title', 'Editar Bus')

@section('content')
<div class="page-header">
    <h4 class="mb-0"><i class="fas fa-pen me-2 text-warning"></i>Editar Bus — {{ $bus->placa }}</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('buses.index') }}">Buses</a></li>
            <li class="breadcrumb-item active">{{ $bus->placa }}</li>
        </ol>
    </nav>
</div>
<div class="card shadow-sm border-0" style="max-width:680px">
    <div class="card-body">
        <form method="POST" action="{{ route('buses.update', $bus) }}">
            @csrf @method('PUT')
            @include('buses._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i> Actualizar</button>
                <a href="{{ route('buses.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
