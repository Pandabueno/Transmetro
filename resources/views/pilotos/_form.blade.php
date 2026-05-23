@php $editando = isset($piloto); @endphp

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
               value="{{ old('nombre', $piloto->nombre ?? '') }}" required>
        @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Bus Asignado</label>
        <select name="bus_id" class="form-select @error('bus_id') is-invalid @enderror">
            <option value="">— Sin bus —</option>
            @foreach($buses as $b)
            <option value="{{ $b->id }}" {{ old('bus_id', $piloto->bus_id ?? '') == $b->id ? 'selected' : '' }}>
                {{ $b->placa }} {{ $b->linea ? '(' . $b->linea->nombre . ')' : '(sin línea)' }}
            </option>
            @endforeach
        </select>
        @error('bus_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
               value="{{ old('telefono', $piloto->telefono ?? '') }}" placeholder="5512-0000" required>
        @error('telefono')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $piloto->email ?? '') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-12">
        <label class="form-label fw-semibold">Dirección <span class="text-danger">*</span></label>
        <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
               value="{{ old('direccion', $piloto->direccion ?? '') }}" required>
        @error('direccion')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Historial educativo dinámico --}}
<div class="card border-0 bg-light mb-3">
    <div class="card-header bg-transparent fw-semibold d-flex align-items-center justify-content-between">
        <span><i class="fas fa-graduation-cap me-1 text-primary"></i> Historial Educativo</span>
        <button type="button" id="btnAddHist" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-plus me-1"></i> Agregar
        </button>
    </div>
    <div class="card-body p-2" id="histContainer">
        @php $historial = old('historial', $editando ? $piloto->historialEducativo->toArray() : []); @endphp
        @forelse($historial as $i => $h)
        <div class="row g-2 mb-2 hist-row align-items-start">
            @if(!empty($h['id']))
            <input type="hidden" name="historial[{{ $i }}][id]" value="{{ $h['id'] }}">
            @endif
            <div class="col-md-5">
                <input type="text" name="historial[{{ $i }}][institucion]" class="form-control form-control-sm"
                       placeholder="Institución" value="{{ $h['institucion'] ?? '' }}" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="historial[{{ $i }}][titulo]" class="form-control form-control-sm"
                       placeholder="Título obtenido" value="{{ $h['titulo'] ?? '' }}" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="historial[{{ $i }}][anio_graduacion]" class="form-control form-control-sm"
                       placeholder="Año" value="{{ $h['anio_graduacion'] ?? '' }}" min="1950" max="{{ date('Y') }}" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-hist">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        </div>
        @empty
        <p class="text-muted small mb-2" id="noHistMsg">No hay historial registrado aún.</p>
        @endforelse
    </div>
</div>

<script>
(function () {
    const container = document.getElementById('histContainer');
    let idx = {{ count($historial ?? []) }};

    document.getElementById('btnAddHist').addEventListener('click', function () {
        document.getElementById('noHistMsg')?.remove();
        container.insertAdjacentHTML('beforeend', `
        <div class="row g-2 mb-2 hist-row align-items-start">
            <div class="col-md-5">
                <input type="text" name="historial[${idx}][institucion]" class="form-control form-control-sm" placeholder="Institución" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="historial[${idx}][titulo]" class="form-control form-control-sm" placeholder="Título obtenido" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="historial[${idx}][anio_graduacion]" class="form-control form-control-sm" placeholder="Año" min="1950" max="{{ date('Y') }}" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-hist"><i class="fas fa-xmark"></i></button>
            </div>
        </div>`);
        idx++;
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-hist')) {
            e.target.closest('.hist-row').remove();
        }
    });
})();
</script>
