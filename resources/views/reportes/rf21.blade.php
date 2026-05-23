<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>RF-21 — Tiempos de Espera</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
    h2 { color: #1a3a5c; border-bottom: 2px solid #0dcaf0; padding-bottom: 6px; }
    h3 { color: #1a3a5c; font-size: 13px; margin-top: 20px; }
    .meta { color: #666; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    th { background: #0dcaf0; color: #1a3a5c; padding: 8px; text-align: left; font-size: 11px; }
    td { padding: 7px 8px; border-bottom: 1px solid #e0e0e0; }
    tr:nth-child(even) td { background: #f0faff; }
    .high { color: #dc3545; font-weight: bold; }
    .med { color: #ffc107; }
    .low { color: #198754; }
    @media print { body { margin: 0; } }
</style>
</head>
<body>
<h2><i>RF-21</i> — Tiempos de Espera de Buses</h2>
<p class="meta">
    Generado: {{ now()->format('d/m/Y H:i') }} — Sistema Transmetro Guatemala / Panda Solutions<br>
    Total registros: {{ $registros->count() }}
</p>

<h3>Resumen por Bus</h3>
<table>
    <thead>
        <tr>
            <th>Bus</th>
            <th>Línea</th>
            <th>Registros</th>
            <th>Promedio (min)</th>
            <th>Máximo (min)</th>
        </tr>
    </thead>
    <tbody>
    @foreach($promedioPorBus as $p)
    @php
        $cls = $p['promedio'] >= 10 ? 'high' : ($p['promedio'] >= 5 ? 'med' : 'low');
    @endphp
    <tr>
        <td class="font-mono">{{ $p['bus']?->placa ?? '—' }}</td>
        <td>{{ $p['bus']?->linea?->nombre ?? '—' }}</td>
        <td>{{ $p['total'] }}</td>
        <td class="{{ $cls }}">{{ $p['promedio'] }}</td>
        <td>{{ $p['max'] }}</td>
    </tr>
    @endforeach
    </tbody>
</table>

<h3>Detalle de Registros</h3>
<table>
    <thead>
        <tr>
            <th>Fecha/Hora</th>
            <th>Bus</th>
            <th>Estación</th>
            <th>Espera (min)</th>
        </tr>
    </thead>
    <tbody>
    @forelse($registros as $r)
    @php $cls = $r->minutos_espera >= 10 ? 'high' : ($r->minutos_espera >= 5 ? 'med' : 'low'); @endphp
    <tr>
        <td>{{ \Carbon\Carbon::parse($r->fecha_hora)->format('d/m/Y H:i') }}</td>
        <td>{{ $r->bus?->placa ?? '—' }}</td>
        <td>{{ $r->estacion?->nombre ?? '—' }}</td>
        <td class="{{ $cls }}">{{ $r->minutos_espera }}</td>
    </tr>
    @empty
    <tr><td colspan="4" style="text-align:center;color:#999">Sin registros.</td></tr>
    @endforelse
    </tbody>
</table>

@if(request()->routeIs('reportes.rf21'))
<div style="margin-top:20px">
    <a href="{{ route('reportes.index') }}" style="color:#0d6efd">← Volver a Reportes</a>
    &nbsp;&nbsp;
    <a href="{{ route('reportes.rf21.pdf') }}" style="color:#dc3545">Descargar PDF</a>
    &nbsp;&nbsp;
    <a href="javascript:window.print()" style="color:#198754">Imprimir</a>
</div>
@endif
</body>
</html>
