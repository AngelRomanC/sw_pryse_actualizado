<?php

namespace App\Http\Controllers;

use App\Models\Cuip;
use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CuipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cuips = Cuip::whereHas('persona', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('persona')->paginate(8);

        return Inertia::render('Cuip/Index', [
            'cuips' => $cuips
        ]);
    }

    public function create()
    {
        $personas = Persona::where('user_id', auth()->id())
            ->whereDoesntHave('cuips')
            ->get();

        return Inertia::render('Cuip/Create', [
            'personas' => $personas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'folio_cuip' => 'nullable|string|max:50',
            'fecha_expedicion' => 'nullable|date',
            'estatus_rfc' => 'nullable|string|max:50',
            'vigencia_ine' => 'nullable|string|max:50',
            'estado_ine' => 'nullable|string|max:50',
            'valida_ine' => 'nullable|string|max:50'
        ]);

        Cuip::create($validated);

        return redirect()->route('cuip.index')->with('success', 'Registro guardado correctamente');
    }

    public function edit(Cuip $cuip)
    {
        if ($cuip->persona->user_id !== auth()->id()) {
            return redirect()->route('cuip.index')->with('error', 'No tienes permiso para editar este registro.');
        }

        return Inertia::render('Cuip/Edit', [
            'cuip' => $cuip
        ]);
    }

    public function update(Request $request, Cuip $cuip)
    {
        if ($cuip->persona->user_id !== auth()->id()) {
            return redirect()->route('cuip.index')->with('error', 'No tienes permiso para actualizar este registro.');
        }

        $validated = $request->validate([
            'folio_cuip' => 'nullable|string|max:50',
            'fecha_expedicion' => 'nullable|date',
            'estatus_rfc' => 'nullable|string|max:50',
            'vigencia_ine' => 'nullable|string|max:50',
            'estado_ine' => 'nullable|string|max:50',
            'valida_ine' => 'nullable|string|max:50'
        ]);

        $cuip->update($validated);

        return redirect()->route('cuip.index')->with('success', 'Registro actualizado correctamente');
    }

    public function destroy(Cuip $cuip)
    {
        if ($cuip->persona->user_id !== auth()->id()) {
            return redirect()->route('cuip.index')->with('error', 'No tienes permiso para eliminar este registro.');
        }

        $cuip->delete();

        return redirect()->route('cuip.index')->with('success', 'Registro eliminado correctamente');
    }
}
