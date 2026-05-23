<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>RF-19 — Buses por Línea</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
    h2 { color: #1a3a5c; border-bottom: 2px solid #0d6efd; padding-bottom: 6px; }
    .meta { color: #666; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    th { background: #1a3a5c; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
    td { padding: 7px 8px; border-bottom: 1px solid #e0e0e0; }
    tr:nth-child(even) td { background: #f8f9fa; }
    .ok { color: #198754; font-weight: bold; }
    .fail { color: #dc3545; font-weight: bold; }
    .section-title { background: #e9f0ff; padding: 6px 8px; font-weight: bold; color: #1a3a5c; margin-top: 10px; }
    @media print { body { margin: 0; } }
</style>
</head>
<body>
<h2><i>RF-19</i> — Reporte de Buses por Línea</h2>
<p class="meta">Generado: {{ now()->format('d/m/Y H:i') }} — Sistema Transmetro Guatemala / Panda Solutions</p>

@foreach($lineas as $linea)
<div class="section-title">
    {{ $linea->nombre }} — {{ $linea->municipalidad->nombre }} |
    Distancia: {{ number_format($linea->distancia_total, 1) }} km |
    Estaciones: {{ $linea->estaciones->count() }} |
    Buses: {{ $linea->buses->count() }}/{{ $linea->estaciones->count() * 2 }} —
    @if($linea->cumpleMinimoBuses())
        <span class="ok">CUMPLE MÍNIMO</span>
    @else
        <span class="fail">INSUFICIENTE</span>
    @endif
</div>

@if($linea->buses->isNotEmpty())
<table>
    <thead>
        <tr>
            <th>Placa</th>
            <th>Capacidad</th>
            <th>Piloto</th>
        </tr>
    </thead>
    <tbody>
    @foreach($linea->buses as $bus)
    <tr>
        <td>{{ $bus->placa }}</td>
        <td>{{ $bus->capacidad_max }} pax</td>
        <td>{{ $bus->piloto?->nombre ?? '—' }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
@else
<p style="color:#999;padding-left:8px">Sin buses asignados.</p>
@endif
@endforeach

@if(request()->routeIs('reportes.rf19'))
<div style="margin-top:20px">
    <a href="{{ route('reportes.index') }}" style="color:#0d6efd">← Volver a Reportes</a>
    &nbsp;&nbsp;
    <a href="{{ route('reportes.rf19.pdf') }}" style="color:#dc3545">Descargar PDF</a>
    &nbsp;&nbsp;
    <a href="javascript:window.print()" style="color:#198754">Imprimir</a>
</div>
@endif
</body>
</html>
