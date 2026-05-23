<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Estacion;
use App\Models\Municipalidad;
use Illuminate\Http\Request;

class EstacionController extends Controller
{
    public function index()
    {
        $estaciones = Estacion::with(['municipalidad', 'accesos', 'parqueos', 'alertas' => fn($q) => $q->where('atendida', false)])
            ->orderBy('nombre')->get();
        return view('estaciones.index', compact('estaciones'));
    }

    public function create()
    {
        $municipalidades = Municipalidad::orderBy('nombre')->get();
        return view('estaciones.create', compact('municipalidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'municipalidad_id' => ['required', 'exists:municipalidades,id'],
            'nombre'           => ['required', 'string', 'max:150'],
            'capacidad_maxima' => ['required', 'integer', 'min:1'],
            'ocupacion_actual' => ['required', 'integer', 'min:0'],
        ]);

        $estacion = Estacion::create($data);
        $estacion->generarAlertaSiNecesario();

        return redirect()->route('estaciones.index')->with('success', "Estación '{$estacion->nombre}' creada.");
    }

    public function show(Estacion $estacion)
    {
        $estacion->load([
            'municipalidad',
            'lineas',
            'accesos.guardia',
            'parqueos',
            'alertas' => fn($q) => $q->orderByDesc('fecha_hora')->limit(10),
        ]);
        return view('estaciones.show', compact('estacion'));
    }

    public function edit(Estacion $estacion)
    {
        $municipalidades = Municipalidad::orderBy('nombre')->get();
        return view('estaciones.edit', compact('estacion', 'municipalidades'));
    }

    public function update(Request $request, Estacion $estacion)
    {
        $data = $request->validate([
            'municipalidad_id' => ['required', 'exists:municipalidades,id'],
            'nombre'           => ['required', 'string', 'max:150'],
            'capacidad_maxima' => ['required', 'integer', 'min:1'],
            'ocupacion_actual' => ['required', 'integer', 'min:0'],
        ]);

        $ocupacionAntes = $estacion->ocupacion_actual;
        $estacion->update($data);

        // Alerta automática si subió la ocupación y supera el 50 %
        if ($data['ocupacion_actual'] > $ocupacionAntes) {
            $estacion->generarAlertaSiNecesario();
        }

        return redirect()->route('estaciones.index')->with('success', "Estación '{$estacion->nombre}' actualizada.");
    }

    public function destroy(Estacion $estacion)
    {
        if ($estacion->lineas()->count() > 0) {
            return back()->with('error', "No se puede eliminar '{$estacion->nombre}' porque está asignada a una línea.");
        }
        $nombre = $estacion->nombre;
        $estacion->delete();
        return redirect()->route('estaciones.index')->with('success', "Estación '{$nombre}' eliminada.");
    }
}
