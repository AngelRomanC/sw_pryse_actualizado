<?php

namespace App\Http\Controllers;

use App\Models\Canpe;
use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CanpeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Listar los registros de Canpe que pertenecen a las personas registradas por el usuario
     */
    public function index()
    {
        // Obtener solo los Canpes que pertenecen al usuario autenticado
        $canpes = Canpe::whereHas('persona', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('persona')->paginate(8);

        return Inertia::render('Canpe/Index', [
            'canpes' => $canpes
        ]);
    }


    /**
     * Mostrar formulario de creación
     */
    public function create()
    {

        // Obtener las personas que pertenecen al usuario autenticado y que no tienen un Canpe registrado
        $personas = Persona::where('user_id', auth()->id())
            ->whereDoesntHave('canpes') // Filtrar solo las personas sin Canpe
            ->get();

        return Inertia::render('Canpe/Create', [
            'personas' => $personas
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'registrado_canpe' => 'nullable|string',
            'estatus_canpe' => 'nullable|string',
            'correo_canpe' => 'nullable|email|unique:canpes,correo_canpe',
            'password_canpe' => 'nullable|string|min:6',
            'inaccesible_canpe' => 'boolean'
        ]);

        Canpe::create($validated);

        return redirect()->route('canpe.index')->with('success', 'Registro guardado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Canpe $canpe)
    {
        //
    }

    // Mostrar formulario de edición
    public function edit(Canpe $canpe)
    {
        // Validar que la persona de este Canpe fue registrada por el usuario autenticado
        if ($canpe->persona->user_id !== auth()->id()) {
            return redirect()->route('canpe.index')->with('error', 'No tienes permiso para editar este registro.');
        }

        return Inertia::render('Canpe/Edit', [
            'canpe' => $canpe
        ]);
    }

    // Actualizar un Canpe
    public function update(Request $request, Canpe $canpe)
    {
        if ($canpe->persona->user_id !== auth()->id()) {
            return redirect()->route('canpe.index')->with('error', 'No tienes permiso para actualizar este registro.');
        }

        $validated = $request->validate([
            'registrado_canpe' => 'required|string',
            'estatus_canpe' => 'nullable|string',
            'correo_canpe' => 'nullable|email|unique:canpes,correo_canpe,' . $canpe->id,
            'password_canpe' => 'nullable|string|min:6',
            'inaccesible_canpe' => 'boolean'
        ]);
     

        $canpe->update($validated);

        return redirect()->route('canpe.index')->with('success', 'Registro actualizado correctamente');
    }

    // Eliminar un Canpe
    public function destroy(Canpe $canpe)
    {
        if ($canpe->persona->user_id !== auth()->id()) {
            return redirect()->route('canpe.index')->with('error', 'No tienes permiso para eliminar este registro.');
        }

        $canpe->delete();

        return redirect()->route('canpe.index')->with('success', 'Registro eliminado correctamente');
    }
}
