<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Linea;
use App\Models\Parqueo;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with(['linea', 'parqueo.estacion', 'piloto'])->orderBy('placa')->get();
        return view('buses.index', compact('buses'));
    }

    public function create()
    {
        $lineas   = Linea::orderBy('nombre')->get();
        $parqueos = Parqueo::with('estacion')->orderBy('nombre')->get();
        return view('buses.create', compact('lineas', 'parqueos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'placa'        => ['required', 'string', 'max:20', 'unique:buses,placa'],
            'capacidad_max'=> ['required', 'integer', 'min:1'],
            'linea_id'     => ['nullable', 'exists:lineas,id'],
            'parqueo_id'   => ['nullable', 'exists:parqueos,id'],
        ]);

        if (! empty($data['linea_id'])) {
            $linea = Linea::find($data['linea_id']);
            if (! $linea->puedeAgregarBus()) {
                return back()->withInput()->withErrors([
                    'linea_id' => "La línea '{$linea->nombre}' ya alcanzó el límite de buses (máx. " . ($linea->estaciones()->count() * 2) . ").",
                ]);
            }
        }

        $bus = Bus::create($data);

        // Actualizar contador en la línea
        if ($bus->linea_id) {
            $bus->linea->update(['cantidad_buses' => $bus->linea->buses()->count()]);
        }

        return redirect()->route('buses.index')->with('success', "Bus '{$bus->placa}' registrado.");
    }

    public function show(Bus $bus)
    {
        $bus->load(['linea.estaciones', 'parqueo.estacion', 'piloto.historialEducativo', 'registroEsperas' => fn($q) => $q->orderByDesc('fecha_hora')->limit(10)]);
        return view('buses.show', compact('bus'));
    }

    public function edit(Bus $bus)
    {
        $lineas   = Linea::orderBy('nombre')->get();
        $parqueos = Parqueo::with('estacion')->orderBy('nombre')->get();
        return view('buses.edit', compact('bus', 'lineas', 'parqueos'));
    }

    public function update(Request $request, Bus $bus)
    {
        $data = $request->validate([
            'placa'         => ['required', 'string', 'max:20', 'unique:buses,placa,' . $bus->id],
            'capacidad_max' => ['required', 'integer', 'min:1'],
            'linea_id'      => ['nullable', 'exists:lineas,id'],
            'parqueo_id'    => ['nullable', 'exists:parqueos,id'],
        ]);

        // Validar límite solo si cambia de línea o se asigna una nueva
        if (! empty($data['linea_id']) && $data['linea_id'] != $bus->linea_id) {
            $linea = Linea::find($data['linea_id']);
            if (! $linea->puedeAgregarBus()) {
                return back()->withInput()->withErrors([
                    'linea_id' => "La línea '{$linea->nombre}' ya alcanzó el límite de buses.",
                ]);
            }
        }

        $lineaAntes = $bus->linea_id;
        $bus->update($data);

        // Actualizar contadores
        if ($lineaAntes) {
            Linea::find($lineaAntes)?->update(['cantidad_buses' => Bus::where('linea_id', $lineaAntes)->count()]);
        }
        if ($bus->linea_id) {
            $bus->linea->update(['cantidad_buses' => $bus->linea->buses()->count()]);
        }

        return redirect()->route('buses.index')->with('success', "Bus '{$bus->placa}' actualizado.");
    }

    public function destroy(Bus $bus)
    {
        $placa    = $bus->placa;
        $lineaId  = $bus->linea_id;
        $bus->delete();

        if ($lineaId) {
            Linea::find($lineaId)?->update(['cantidad_buses' => Bus::where('linea_id', $lineaId)->count()]);
        }

        return redirect()->route('buses.index')->with('success', "Bus '{$placa}' eliminado.");
    }
}
