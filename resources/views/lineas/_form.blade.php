@php $editando = isset($linea); @endphp

<div class="mb-3">
    <label class="form-label fw-semibold">Nombre de la Línea <span class="text-danger">*</span></label>
    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
           value="{{ old('nombre', $linea->nombre ?? '') }}" placeholder="Ej: Línea 12" required>
    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Municipalidad <span class="text-danger">*</span></label>
        <select name="municipalidad_id" class="form-select @error('municipalidad_id') is-invalid @enderror" required>
            <option value="">— Seleccione —</option>
            @foreach($municipalidades as $m)
            <option value="{{ $m->id }}" {{ old('municipalidad_id', $linea->municipalidad_id ?? '') == $m->id ? 'selected' : '' }}>
                {{ $m->nombre }}
            </option>
            @endforeach
        </select>
        @error('municipalidad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Distancia Total (km) <span class="text-danger">*</span></label>
        <input type="number" name="distancia_total" step="0.1" min="0"
               class="form-control @error('distancia_total') is-invalid @enderror"
               value="{{ old('distancia_total', $linea->distancia_total ?? '') }}" placeholder="18.5" required>
        @error('distancia_total')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

{{-- Estaciones en línea --}}
<div class="card border-0 bg-light mb-3">
    <div class="card-header bg-transparent fw-semibold">
        <i class="fas fa-map-pin me-1 text-primary"></i> Estaciones en la Línea
        <button type="button" id="btnAddEst" class="btn btn-sm btn-outline-primary float-end">
            <i class="fas fa-plus me-1"></i> Agregar
        </button>
    </div>
    <div class="card-body p-2">
        <div id="estacionesContainer">
            @php
                $estAsignadas = $editando ? $linea->estaciones : collect();
            @endphp
            @forelse($estAsignadas as $i => $est)
            <div class="row g-2 mb-2 est-row align-items-center">
                <div class="col-md-5">
                    <select name="estaciones[]" class="form-select form-select-sm">
                        <option value="">— Estación —</option>
                        @foreach($estaciones as $e)
                        <option value="{{ $e->id }}" {{ $e->id == $est->id ? 'selected' : '' }}>
                            {{ $e->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="orden[]" class="form-control form-control-sm"
                           placeholder="Orden" value="{{ $est->pivot->orden }}" min="1">
                </div>
                <div class="col-md-3">
                    <input type="number" name="distancia_est[]" step="0.1" class="form-control form-control-sm"
                           placeholder="Dist. km" value="{{ $est->pivot->distancia }}">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-est">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
            </div>
            @empty
            <p class="text-muted small mb-2" id="noEstMsg">No hay estaciones asignadas aún.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
(function () {
    const container = document.getElementById('estacionesContainer');
    const noMsg     = document.getElementById('noEstMsg');
    const estOpts   = @json($estaciones->pluck('nombre', 'id'));

    function buildRow(count) {
        let opts = '<option value="">— Estación —</option>';
        for (const [id, nombre] of Object.entries(estOpts)) {
            opts += `<option value="${id}">${nombre}</option>`;
        }
        return `
        <div class="row g-2 mb-2 est-row align-items-center">
            <div class="col-md-5"><select name="estaciones[]" class="form-select form-select-sm">${opts}</select></div>
            <div class="col-md-3"><input type="number" name="orden[]" class="form-control form-control-sm" placeholder="Orden" value="${count}" min="1"></div>
            <div class="col-md-3"><input type="number" name="distancia_est[]" step="0.1" class="form-control form-control-sm" placeholder="Dist. km" value="0"></div>
            <div class="col-md-1"><button type="button" class="btn btn-sm btn-outline-danger btn-remove-est"><i class="fas fa-xmark"></i></button></div>
        </div>`;
    }

    document.getElementById('btnAddEst').addEventListener('click', function () {
        noMsg?.remove();
        const count = container.querySelectorAll('.est-row').length + 1;
        container.insertAdjacentHTML('beforeend', buildRow(count));
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-est')) {
            e.target.closest('.est-row').remove();
        }
    });
})();
</script>
