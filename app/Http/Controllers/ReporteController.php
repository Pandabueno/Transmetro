<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Bus;
use App\Models\Linea;
use App\Models\RegistroEspera;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    // RF-19: Reporte de buses por línea con estado de mínimos
    public function rf19(string $formato = 'html')
    {
        $lineas = Linea::with(['estaciones', 'buses.piloto'])->orderBy('nombre')->get();
        $view = view('reportes.rf19', compact('lineas'));

        if ($formato === 'pdf') {
            $pdf = Pdf::loadHTML($view->render())->setPaper('a4', 'landscape');
            return $pdf->download('reporte-buses-por-linea.pdf');
        }
        return $view;
    }

    // RF-20: Reporte de alertas de ocupación por estación
    public function rf20(string $formato = 'html')
    {
        $alertas = Alerta::with(['estacion', 'operadorAtencion'])
            ->orderByDesc('fecha_hora')
            ->get();
        $view = view('reportes.rf20', compact('alertas'));

        if ($formato === 'pdf') {
            $pdf = Pdf::loadHTML($view->render())->setPaper('a4', 'portrait');
            return $pdf->download('reporte-alertas-ocupacion.pdf');
        }
        return $view;
    }

    // RF-21: Reporte de tiempos de espera de buses
    public function rf21(string $formato = 'html')
    {
        $registros = RegistroEspera::with(['bus.linea', 'estacion'])
            ->orderByDesc('fecha_hora')
            ->get();

        $promedioPorBus = $registros->groupBy('bus_id')->map(fn($g) => [
            'bus'     => $g->first()->bus,
            'total'   => $g->count(),
            'promedio'=> round($g->avg('minutos_espera'), 1),
            'max'     => $g->max('minutos_espera'),
        ])->sortByDesc('promedio')->values();

        $view = view('reportes.rf21', compact('registros', 'promedioPorBus'));

        if ($formato === 'pdf') {
            $pdf = Pdf::loadHTML($view->render())->setPaper('a4', 'portrait');
            return $pdf->download('reporte-tiempos-espera.pdf');
        }
        return $view;
    }
}
