<?php

namespace App\Http\Controllers;

use App\Models\FormatoEvaluacion;
use App\Http\Requests\StoreFormatoEvaluacionRequest;
use App\Http\Requests\UpdateFormatoEvaluacionRequest;
use App\Models\Academico;
use App\Models\Grupo;
use App\Models\Habito;
use App\Models\Inteligencia;
use App\Models\Profesor;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;


class FormatoEvaluacionController extends Controller
{
    private FormatoEvaluacion $model;
    private string $routeName;
    private string $source;
    private string $module = 'FormatoEvaluacion';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Evaluacion/';
        $this->model = new FormatoEvaluacion();
        $this->routeName = 'evaluacion.';
    }

    public function index(Request $request): Response
    {
        $user = Auth::user();
        $usuarios = User::all();
        $Evaluacion = FormatoEvaluacion::all();
        $academico = Academico::whereHas('profesor', function ($query) use ($user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        })->with('user', 'grupo')->get();

       $grupo = Academico::with('grupo')->get();
       
        $versions = DB::table('preguntas')
       ->where('estatus',1)
       ->where('formato', 1)
       ->distinct()->pluck('version')->toArray();
       $respuestas = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {
            $query->where('formato', 1);
        })->get();
     
        $preguntas = $respuestas->pluck('pregunta')->unique();

        return Inertia::render("Evaluacion/Index", [
            'titulo'      => 'Formatos contestados ',
            'Evaluacion'    => $Evaluacion,
            'usuarios'      => $usuarios,
            'Academico'     => $academico,
            'respuestas'    => $respuestas,
            'grupo'        => $grupo,
            'version'       =>$versions,
            'preguntas'     =>$preguntas,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

public function evaluacionInteligencia(Request $request): Response
    {
        $user = Auth::user();
        $usuarios = User::all();
        $Evaluacion = FormatoEvaluacion::where('formato', 3)->get();
        $inteligencia = Inteligencia::whereHas('profesor', function ($query) use ($user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        })->with('user', 'grupo')->get();

       $grupo = Academico::with('grupo')->get();
      
        $versions = DB::table('preguntas')
       ->where('formato', 3)
       ->distinct()->pluck('version')->toArray();
       $respuestas = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {
            $query->where('formato', 3);
        })->get();
     
        $preguntas = $respuestas->pluck('pregunta')->unique();

        return Inertia::render("Evaluacion/Inteligencia", [
            'titulo'      => 'Observaciones a estudiantes Inteligencias múltiples',
            'Evaluacion'    => $Evaluacion,
            'usuarios'      => $usuarios,
            'Inteligencia'     => $inteligencia,
            'respuestas'    => $respuestas,
            'grupo'        => $grupo,
            'version'       =>$versions,
            'preguntas'     =>$preguntas,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }


    public function evaluacionAcademico(Request $request): Response
    {
        $user = Auth::user();
        $usuarios = User::all();
        $Evaluacion = FormatoEvaluacion::where('formato', 1)->get();
        $academico = Academico::whereHas('profesor', function ($query) use ($user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
            });
        })->with('user', 'grupo')->get();

       $grupo = Academico::with('grupo')->get();
       
        $versions = DB::table('preguntas')
      
       ->where('formato', 1)
       ->distinct()->pluck('version')->toArray();
       $respuestas = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {
            $query->where('formato', 1);
        })->get();
     
        $preguntas = $respuestas->pluck('pregunta')->unique();

        return Inertia::render("Evaluacion/Academico", [
            'titulo'      => 'Observaciones a estudiantes Análisis Académico Individual',
            'Evaluacion'    => $Evaluacion,
            'usuarios'      => $usuarios,
            'Academico'     => $academico,
            'respuestas'    => $respuestas,
            'grupo'        => $grupo,
            'version'       =>$versions,
            'preguntas'     =>$preguntas,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    public function evaluacionHabito(Request $request): Response
    {
        $user = Auth::user();
        $usuarios = User::all();
   
        $Evaluacion = FormatoEvaluacion::where('formato', 2)->get();
        $habito = Habito::whereHas('profesor', function ($query) use ($user) {
            $query->whereHas('user', function ($query) use ($user) {
                $query->where('id', $user->id);
                $query->where('formato', 2);
            });
        })->with('user', 'grupo')->get();

       $grupo = Habito::with('grupo')->get();
       
        $versions = DB::table('preguntas')
      
       ->where('formato', 2)
       ->distinct()->pluck('version')->toArray();
       $respuestas = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {
            $query->where('formato', 2);
        })->get();
     
        $preguntas = $respuestas->pluck('pregunta')->unique();

        return Inertia::render("Evaluacion/Habito", [
            'titulo'      => 'Observaciones a estudiantes Hábitos de estudio',
            'Evaluacion'    => $Evaluacion,
            'usuarios'      => $usuarios,
            'Habito'     => $habito,
            'respuestas'    => $respuestas,
            'grupo'        => $grupo,
            'version'       =>$versions,
            'preguntas'     =>$preguntas,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }
    public function create()
    {
        //
    }

    public function store(StoreFormatoEvaluacionRequest $request)
    {
        $formato = $request->input('formato');
        $usuario = null;

        if ($formato === 1) {
            $academico_id = $request->input('academico');
            $academico = Academico::findOrFail($academico_id);
            $usuario = $academico->user;
        } elseif ($formato === 2) {
            $habito_id = $request->input('habito');
            $habito = Habito::findOrFail($habito_id);
            $usuario = $habito->user;
        } elseif ($formato === 3) {
            $inteligencia_id = $request->input('inteligencia');
            $inteligencia = Inteligencia::findOrFail($inteligencia_id);
            $usuario = $inteligencia->user;
        } else {

        }

        FormatoEvaluacion::create([
            'respuesta' => $request->input('respuesta'),
            'formato' => $request->input('formato'),
            'version' => $request->input('version'),
            'user_id' =>$usuario->id,
        ]);

    }

    
    public function show(FormatoEvaluacion $formatoEvaluacion)
    {
        //
    }

   
    public function edit(FormatoEvaluacion $formatoEvaluacion)
    {
        //
    }

   
    public function update(UpdateFormatoEvaluacionRequest $request)
    {
        $formato = $request->input('formato');
        $usuario = null;
     
        if ($formato === 1) {
            
            $usuario = $request->input('academico');
        } elseif ($formato === 2) {
            $usuario = $request->input('habito');
        } elseif ($formato === 3) {
            $usuario = $request->input('inteligencia');
        } else {

        }
        $evaluacion = FormatoEvaluacion::find($request->input('evaluacion_id'));
        
        $evaluacion->update([
            'respuesta' => $request->input('respuesta'),
            'formato' => $request->input('formato'),
            'user_id' => $usuario,
            'version' => $request->input('version'),
        ]);
        

    }

    
    public function destroy(FormatoEvaluacion $formatoEvaluacion)
    {
        //
    }
}
