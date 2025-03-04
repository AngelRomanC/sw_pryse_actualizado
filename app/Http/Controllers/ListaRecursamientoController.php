<?php

namespace App\Http\Controllers;

use App\Models\ListaRecursamiento;
use App\Models\Materia;
use App\Http\Requests\StoreListaRecursamientoRequest;
use App\Http\Requests\UpdateListaRecursamientoRequest;
use App\Models\Recursamiento;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Events\RecursamientoEvent2; //anexar ----


class ListaRecursamientoController extends Controller
{
    private ListaRecursamiento $model;
    private string $routeName;
    private string $source;
    private string $module = 'academico';
    
    

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Lista/';
        $this->model = new ListaRecursamiento();
        $this->routeName = 'lista.';
    }

    public function index(Request $request): Response
    {
        $user = Auth::user();

        $recursamiento = Recursamiento::with(['materia', 'periodo', 'profesor.user', 'users'])->where('estatus', 1)->get();


        $recursa = ListaRecursamiento::with('recursamientos')->paginate(10);

        return Inertia::render("Lista/Index", [
            'titulo'      => 'lista de recursamiento',
            'recursamiento' => $recursamiento,
            'routeName'      => $this->routeName,
            'recursa' => $recursa,
            'usuario' => $user,
            'loadingResults' => false
        ]);
    }

    public function assignAlumnoRecursamiento(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'Alumno') {
            return redirect()->route("{$this->routeName}index")->with('error', 'Solo los alumnos pueden ser asignados a recursamientos.');
        }
        $existingAssignment = ListaRecursamiento::where('user_id', $user->id)
            ->where('recursamiento_id', $id)
            ->first();

        if ($existingAssignment) {

            return redirect()->route("{$this->routeName}index")->with('error', 'El alumno ya está asignado a este recursamiento.');
        }
        $recursamiento = ListaRecursamiento::where('recursamiento_id', $id)
            ->count();

        $cupoMaximo = Recursamiento::find($id);

        if ($recursamiento >= $cupoMaximo->cupo) {
            return redirect()->route("{$this->routeName}index")->with('error', 'El recursamiento ha alcanzado su cupo máximo de alumnos.');
        }
        $recursamientoAdmin=ListaRecursamiento::create([
            'user_id' => $user->id,
            'recursamiento_id' => $id,         

        ]);
        $recursamientoAdmin->load('user', 'recursamiento.materia');

        //AQUI METER EVENT       
            event(new RecursamientoEvent2($recursamientoAdmin)); //evento de notificacion


        return redirect()->route("{$this->routeName}index")->with('success', 'Alumno asignado al grupo con éxito----!');
    }
    public function eliminarAlumno($recursamientoId, $userId)
    {


        // Buscar el recursamiento por su ID
        $recursamiento = Recursamiento::findOrFail($recursamientoId);

        // Verificar si el usuario está asociado con este recursamiento
        if ($recursamiento->users()->where('user_id', $userId)->exists()) {
            // Eliminar al usuario de la lista de recursamiento
            $recursamiento->users()->detach($userId);
        }
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreListaRecursamientoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListaRecursamientoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function show(ListaRecursamiento $listaRecursamiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(ListaRecursamiento $listaRecursamiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListaRecursamientoRequest  $request
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListaRecursamientoRequest $request, ListaRecursamiento $listaRecursamiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListaRecursamiento  $listaRecursamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListaRecursamiento $listaRecursamiento)
    {
        //
    }
}
