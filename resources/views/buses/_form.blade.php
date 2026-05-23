@php $editando = isset($bus); @endphp

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Placa <span class="text-danger">*</span></label>
        <input type="text" name="placa" class="form-control font-monospace @error('placa') is-invalid @enderror"
               value="{{ old('placa', $bus->placa ?? '') }}" placeholder="P-001-GTM" required>
        @error('placa')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Capacidad Máxima (pax) <span class="text-danger">*</span></label>
        <input type="number" name="capacidad_max" min="1"
               class="form-control @error('capacidad_max') is-invalid @enderror"
               value="{{ old('capacidad_max', $bus->capacidad_max ?? '') }}" required>
        @error('capacidad_max')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Línea</label>
        <select name="linea_id" id="lineaSelect" class="form-select @error('linea_id') is-invalid @enderror">
            <option value="">— Sin línea —</option>
            @foreach($lineas as $l)
            <option value="{{ $l->id }}"
                    data-est="{{ $l->estaciones()->count() }}"
                    data-buses="{{ $l->buses()->count() }}"
                    {{ old('linea_id', $bus->linea_id ?? '') == $l->id ? 'selected' : '' }}>
                {{ $l->nombre }}
            </option>
            @endforeach
        </select>
        @error('linea_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div id="lineaInfo" class="form-text"></div>
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Parqueo</label>
        <select name="parqueo_id" class="form-select @error('parqueo_id') is-invalid @enderror">
            <option value="">— Sin parqueo —</option>
            @foreach($parqueos as $p)
            <option value="{{ $p->id }}" {{ old('parqueo_id', $bus->parqueo_id ?? '') == $p->id ? 'selected' : '' }}>
                {{ $p->nombre }} ({{ $p->estacion->nombre }})
            </option>
            @endforeach
        </select>
        @error('parqueo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<script>
document.getElementById('lineaSelect').addEventListener('change', function () {
    const opt  = this.options[this.selectedIndex];
    const info = document.getElementById('lineaInfo');
    if (! this.value) { info.textContent = ''; return; }
    const est   = parseInt(opt.dataset.est) || 0;
    const buses = parseInt(opt.dataset.buses) || 0;
    const lim   = est * 2;
    const disp  = Math.max(0, lim - buses);
    info.innerHTML = `Estaciones: <strong>${est}</strong> — Buses: <strong>${buses}/${lim}</strong> — Disponibles: <strong class="${disp===0?'text-danger':'text-success'}">${disp}</strong>`;
});
document.getElementById('lineaSelect').dispatchEvent(new Event('change'));
</script>
