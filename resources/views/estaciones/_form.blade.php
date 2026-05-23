@php $editando = isset($estacion); @endphp

<div class="mb-3">
    <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $estacion->nombre ?? '') }}" placeholder="Ej: Estación Central" required>
    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label fw-semibold">Municipalidad <span class="text-danger">*</span></label>
        <select name="municipalidad_id" class="form-select @error('municipalidad_id') is-invalid @enderror" required>
            <option value="">— Seleccione —</option>
            @foreach($municipalidades as $m)
            <option value="{{ $m->id }}" {{ old('municipalidad_id', $estacion->municipalidad_id ?? '') == $m->id ? 'selected' : '' }}>
                {{ $m->nombre }}
            </option>
            @endforeach
        </select>
        @error('municipalidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Capacidad Máxima <span class="text-danger">*</span></label>
        <input type="number" name="capacidad_maxima" min="1"
               class="form-control @error('capacidad_maxima') is-invalid @enderror"
               value="{{ old('capacidad_maxima', $estacion->capacidad_maxima ?? '') }}" required>
        @error('capacidad_maxima')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Ocupación Actual <span class="text-danger">*</span></label>
        <input type="number" name="ocupacion_actual" min="0"
               class="form-control @error('ocupacion_actual') is-invalid @enderror"
               value="{{ old('ocupacion_actual', $estacion->ocupacion_actual ?? 0) }}" required>
        <div class="form-text text-warning">
            <i class="fas fa-triangle-exclamation me-1"></i>
            Si supera el 50 % se generará una alerta automática.
        </div>
        @error('ocupacion_actual')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
