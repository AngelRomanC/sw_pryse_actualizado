<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Encuesta;
use App\Models\User;
use App\Models\Alumno;
use App\Http\Requests\StoreEncuestaRequest;
use App\Http\Requests\UpdateEncuestaRequest;
use App\Models\ListaRecursamiento;
use App\Models\Materia;
use App\Models\Recursamiento;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class EncuestaController extends Controller
{
    private Encuesta $model;
    private string $routeName;
    private string $source;
    private string $module = 'periodo';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Encuesta/';
        $this->model = new Encuesta();
        $this->routeName = 'encuesta.';
    }

    public function index(Request $request): Response
    {
        $user = Auth::user();

        
        $Recursamiento = Recursamiento::whereHas('lista_recursamientos', function ($query) use ($user) {
            $query->where('user_id', $user->id);
            $query->where('estatus', 0);
        })->with('materia','periodo')->get();
        
        $encuesta = Encuesta::where('user_id', $user->id)->get();
        
        return Inertia::render("Encuesta/Index", [
            'titulo'      => 'Encuestas de recursamiento',
            'Recursamiento' => $Recursamiento,
            'encuesta'      => $encuesta,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    public function create($materia_id)
    {
        $materia = Materia::find($materia_id);
       
        return Inertia::render("Encuesta/Create", [
            'titulo'      => 'Encuestas de recursamiento',
            'routeName'      => $this->routeName,
            'materia'     => $materia,
        ]);
    }


    public function store(StoreEncuestaRequest $request)
    {
        
        $user = Auth::user();
        if ($user->role !== 'Alumno') {
            return redirect()->route("{$this->routeName}index")->with('error', 'Solo los alumnos pueden ser asignados a recursamientos.');
        }
        $existingResponse = Encuesta::where('user_id', $user->id)
        ->where('materia_id', $request->materia['id'])
        ->first();
        if ($existingResponse) {

            return redirect()->route("{$this->routeName}index")->with('error', 'El usuario ya ha respondido a la encuesta.');
        }

        
        Encuesta::Create([
            'horario' => $request->input('horario'),
            'profesores' => $request->input('profesores'),
            'tipo_proyecto' => $request->input('tipo_proyecto'),
            'dificultad' => $request->input('dificultad'),
            'estudiantes' => $request->input('estudiantes'),
            'user_id' => $user->id,
            'materia_id' => $request->materia['id'],

        ]);
        return redirect()->route('encuesta.index');
    }


    public function show(Encuesta $encuesta)
    {
    }


    public function edit($id)
    {
        $Encuesta = Encuesta::find($id);
        return Inertia::render([
            'Encuesta' => $Encuesta,
            'titulo' => 'Modificar formulario',
            'routeName'      => $this->routeName,
        ]);
    }


    public function update(UpdateEncuestaRequest $request, $id)
    {
        $Encuesta = Encuesta::find($id);
        $Encuesta->update($request->all());
        return redirect()->route("Encuesta.index");
    }


    public function destroy($id)
    {
        $Encuesta = Encuesta::find($id);
        $Encuesta->delete();
        return redirect()->route("encuesta.index");
    }
}
