<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private string $routeName; //si sirve
    public function __construct()
    {
        $this->middleware('auth');
        $this->routeName = 'persona.';
    }

    public function index()
    {
        //
        // Filtrar personas solo por el user_id del usuario autenticado
        $personas = Persona::where('user_id', auth()->id())  // Filtra solo las personas del usuario actual
            ->orderBy('id')  // Aplica el orden antes de obtener los resultados
            ->paginate(8)  // Paginación
            ->withQueryString();  // Mantener los parámetros de la URL

        return Inertia::render("Persona/Index", [
            'titulo'      => 'Personas',
            'personas'    => $personas,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    /**
     * Mostrar el formulario para crear una nueva persona.
     */
    public function create()
    {
        //
        return Inertia::render("Persona/Create", [
            'titulo' => 'Agregar Persona',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Guardar una nueva persona en la base de datos.
     */
    public function store(Request $request)
    {
       // Validar los datos recibidos
       $validated = $request->validate([
        'nombre' => 'required|string|max:50',
        'apellido_paterno' => 'required|string|max:50',
        'apellido_materno' => 'required|string|max:50',
        'sexo' => 'required|in:Masculino,Femenino',
        'fecha_nacimiento' => 'required|date',
        'edad' => 'required|integer|min:18',
        'entidad_nacimiento' => 'required|string',
        'rfc' => 'required|string|size:13',
        'cp' => 'required|string|size:5',
        'nss' => 'required|string|size:11',
        'cuip' => 'required|string|size:18',
        'curp' => 'required|string|size:18|regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$/',
    ]);

    // Agregar el user_id del usuario autenticado
    $validated['user_id'] = auth()->id();
    // Crear la persona con los datos validados
    Persona::create($validated);

    // Redirigir a la lista de personas con un mensaje de éxito
    return redirect()->route($this->routeName . 'index')->with('success', 'Persona creada con éxito.');
}
    

/**
     * Display the specified resource.
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Mostrar el formulario para editar los detalles de una persona.
     */
    public function edit(Persona $persona)
    {
        return Inertia::render("Persona/Edit", [
            'titulo' => 'Editar Persona',
            'persona' => $persona,
            'routeName'      => $this->routeName //checar que se exporte 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persona $persona)
    {
        // Validar los datos
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'sexo' => 'required|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'edad' => 'required|integer|min:18',
            'entidad_nacimiento' => 'required|string',
            'rfc' => 'required|string|size:13',
            'cp' => 'required|string|size:5',
            'nss' => 'required|string|size:11',
            'cuip' => 'required|string|size:18',
            'curp' => 'required|string|size:18|regex:/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}$/',
        ]);

        // Actualizar la persona
        $persona->update($validated);

        // Redirigir a la lista de personas con un mensaje de éxito
        return redirect()->route($this->routeName . 'index')->with('success', 'Persona actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persona $persona)
    {
        // Eliminar la persona
        $persona->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route($this->routeName . 'index')->with('success', 'Persona eliminada con éxito.');
    }
}
