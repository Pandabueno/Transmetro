@extends('layouts.app')
@section('title', 'Nuevo Bus')

@section('content')
<div class="page-header">
    <h4 class="mb-0"><i class="fas fa-plus-circle me-2 text-primary"></i>Nuevo Bus</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 small">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('buses.index') }}">Buses</a></li>
            <li class="breadcrumb-item active">Nuevo</li>
        </ol>
    </nav>
</div>
<div class="card shadow-sm border-0" style="max-width:680px">
    <div class="card-body">
        <form method="POST" action="{{ route('buses.store') }}">
            @csrf
            @include('buses._form')
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Guardar</button>
                <a href="{{ route('buses.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
