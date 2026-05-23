<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>RF-20 — Alertas de Ocupación</title>
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
    h2 { color: #1a3a5c; border-bottom: 2px solid #dc3545; padding-bottom: 6px; }
    .meta { color: #666; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #dc3545; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
    td { padding: 7px 8px; border-bottom: 1px solid #e0e0e0; }
    tr:nth-child(even) td { background: #fff5f5; }
    .pendiente { color: #dc3545; font-weight: bold; }
    .atendida { color: #198754; }
    @media print { body { margin: 0; } }
</style>
</head>
<body>
<h2><i>RF-20</i> — Alertas de Ocupación por Estación</h2>
<p class="meta">
    Generado: {{ now()->format('d/m/Y H:i') }} — Sistema Transmetro Guatemala / Panda Solutions<br>
    Total alertas: {{ $alertas->count() }} |
    Pendientes: {{ $alertas->where('atendida', false)->count() }} |
    Atendidas: {{ $alertas->where('atendida', true)->count() }}
</p>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Estación</th>
            <th>Tipo</th>
            <th>Fecha/Hora</th>
            <th>Estado</th>
            <th>Atendida por</th>
        </tr>
    </thead>
    <tbody>
    @forelse($alertas as $a)
    <tr>
        <td>{{ $a->id }}</td>
        <td>{{ $a->estacion->nombre }}</td>
        <td>{{ ucfirst($a->tipo) }}</td>
        <td>{{ $a->fecha_hora->format('d/m/Y H:i') }}</td>
        <td>
            @if($a->atendida)
                <span class="atendida">Atendida</span>
            @else
                <span class="pendiente">Pendiente</span>
            @endif
        </td>
        <td>{{ $a->operadorAtencion?->nombre ?? '—' }}</td>
    </tr>
    @empty
    <tr><td colspan="6" style="text-align:center;color:#999">Sin alertas registradas.</td></tr>
    @endforelse
    </tbody>
</table>

@if(request()->routeIs('reportes.rf20'))
<div style="margin-top:20px">
    <a href="{{ route('reportes.index') }}" style="color:#0d6efd">← Volver a Reportes</a>
    &nbsp;&nbsp;
    <a href="{{ route('reportes.rf20.pdf') }}" style="color:#dc3545">Descargar PDF</a>
    &nbsp;&nbsp;
    <a href="javascript:window.print()" style="color:#198754">Imprimir</a>
</div>
@endif
</body>
</html>
