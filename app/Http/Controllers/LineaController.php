<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use App\Models\Linea;
use App\Models\Municipalidad;
use Illuminate\Http\Request;

class LineaController extends Controller
{
    public function index()
    {
        $lineas = Linea::with(['municipalidad', 'estaciones', 'buses'])->orderBy('nombre')->get();
        return view('lineas.index', compact('lineas'));
    }

    public function create()
    {
        $municipalidades = Municipalidad::orderBy('nombre')->get();
        $estaciones      = Estacion::orderBy('nombre')->get();
        return view('lineas.create', compact('municipalidades', 'estaciones'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'municipalidad_id' => ['required', 'exists:municipalidades,id'],
            'nombre'           => ['required', 'string', 'max:100'],
            'distancia_total'  => ['required', 'numeric', 'min:0'],
            'estaciones'       => ['nullable', 'array'],
            'estaciones.*'     => ['exists:estaciones,id'],
            'orden'            => ['nullable', 'array'],
            'distancia_est'    => ['nullable', 'array'],
        ]);

        $linea = Linea::create([
            'municipalidad_id' => $data['municipalidad_id'],
            'nombre'           => $data['nombre'],
            'distancia_total'  => $data['distancia_total'],
            'cantidad_buses'   => 0,
        ]);

        if (! empty($data['estaciones'])) {
            $pivot = [];
            foreach ($data['estaciones'] as $i => $estId) {
                $pivot[$estId] = [
                    'orden'     => ($request->input("orden.$i") ?? ($i + 1)),
                    'distancia' => ($request->input("distancia_est.$i") ?? 0),
                ];
            }
            $linea->estaciones()->attach($pivot);
        }

        return redirect()->route('lineas.index')->with('success', "Línea '{$linea->nombre}' creada correctamente.");
    }

    public function show(Linea $linea)
    {
        $linea->load(['municipalidad', 'estaciones', 'buses.piloto']);
        return view('lineas.show', compact('linea'));
    }

    public function edit(Linea $linea)
    {
        $municipalidades = Municipalidad::orderBy('nombre')->get();
        $estaciones      = Estacion::orderBy('nombre')->get();
        $linea->load('estaciones');
        return view('lineas.edit', compact('linea', 'municipalidades', 'estaciones'));
    }

    public function update(Request $request, Linea $linea)
    {
        $data = $request->validate([
            'municipalidad_id' => ['required', 'exists:municipalidades,id'],
            'nombre'           => ['required', 'string', 'max:100'],
            'distancia_total'  => ['required', 'numeric', 'min:0'],
            'estaciones'       => ['nullable', 'array'],
            'estaciones.*'     => ['exists:estaciones,id'],
            'orden'            => ['nullable', 'array'],
            'distancia_est'    => ['nullable', 'array'],
        ]);

        $linea->update([
            'municipalidad_id' => $data['municipalidad_id'],
            'nombre'           => $data['nombre'],
            'distancia_total'  => $data['distancia_total'],
        ]);

        $pivot = [];
        foreach (($data['estaciones'] ?? []) as $i => $estId) {
            $pivot[$estId] = [
                'orden'     => ($request->input("orden.$i") ?? ($i + 1)),
                'distancia' => ($request->input("distancia_est.$i") ?? 0),
            ];
        }
        $linea->estaciones()->sync($pivot);

        return redirect()->route('lineas.index')->with('success', "Línea '{$linea->nombre}' actualizada.");
    }

    public function destroy(Linea $linea)
    {
        if ($linea->buses()->count() > 0) {
            return back()->with('error', "No se puede eliminar '{$linea->nombre}' porque tiene buses asignados.");
        }
        $nombre = $linea->nombre;
        $linea->estaciones()->detach();
        $linea->delete();
        return redirect()->route('lineas.index')->with('success', "Línea '{$nombre}' eliminada.");
    }
}
