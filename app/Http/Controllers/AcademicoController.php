<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\Academico;
use App\Models\Respuesta;
use App\Http\Requests\StoreAcademicoRequest;
use App\Http\Requests\UpdateAcademicoRequest;
use App\Models\Alumno;
use App\Models\FormatoEvaluacion;
use App\Models\Grupo;
use App\Models\Grupo_Alumnos;
use App\Models\Habilitarversiones;
use App\Models\Habito;
use App\Models\Inteligencia;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Models\User;
use App\Models\Periodo;
use App\Models\Profesor;


class AcademicoController extends Controller
{
    private Academico $model;
    private string $routeName;
    private string $source;
    private string $module = 'academico';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Academico/';
        $this->model = new Academico();
        $this->routeName = 'academico.';

   }
   
   public function index(Request $request): Response
   {
        $user = Auth::user();
        $profesor=Profesor::all();
        
        $academicoId = $user->academico ? $user->academico->id : null;
        $Academico = $user->Academico;
        
        $Academicos = Academico::where('user_id', $user->id)->get();
        

       $profesor = $Academico ? Profesor::find($Academico->profesor_id) : null;
       $periodo = $Academico ? Periodo::find($Academico->periodo_id) : null;
       $grupo = $Academico ? Grupo::find($Academico->grupo_id) : null;
       $usuarioProfesor = $profesor ? User::find($profesor->user_id) : null;
       $versions = DB::table('preguntas')
       ->where('estatus',1)
       ->where('formato', 1)
       ->distinct()->pluck('version')->toArray();
       $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 1);
        })->get();
        $preguntas = $respuestas->pluck('pregunta')->unique();

        $alumnoId = Alumno::where('user_id', $user->id)->first(); 
        $alumnoId = $alumnoId ->id;
        if($alumnoId){
        $grupoAlumno = Grupo_Alumnos::where('alumno_id', $alumnoId)->first();
        $registros = Habilitarversiones::where('grupo_alumno', $grupoAlumno->id)->where('formato',1)->where('estatus',1)->get();
        
        }

       return Inertia::render("Academico/Index", [
           'titulo'      => 'Formato de analisis academico',
           'Academico'    => $Academicos,
           'grupo'        => $grupo,
           'academicoId' => $academicoId,
           'routeName'      => $this->routeName,
           'preguntas'      => $preguntas,  
           'respuestas'     => $respuestas,
            'profesor'      =>$usuarioProfesor,
            'periodo'      =>$periodo,
            'versions' => $versions,
           'version_habilitada' => $registros,
           'loadingResults' => false
       ]);
   }

   public function observacion(Request $request): Response
   {
    $user = Auth::user();

    $academicos = Academico::where('user_id', $user->id)->with('user', 'grupo')->get();
    $habitos = Habito::where('user_id', $user->id)->with('user', 'grupo')->get();
    $inteligencias = Inteligencia::where('user_id', $user->id)->with('user', 'grupo')->get();
    

    $grupo = Academico::with('grupo')->get();
    $grupohabitos = Habito::with('grupo')->get();
    $grupointeligencia = Inteligencia::with('grupo')->get();


   $versions = Pregunta::where('estatus', 1)->where('formato', 1)->distinct()->pluck('version')->toArray();
   $versionHabito = Pregunta::where('estatus', 1)->where('formato', 2)->distinct()->pluck('version')->toArray();
   $versionInteligencia = Pregunta::where('estatus', 1)->where('formato', 3)->distinct()->pluck('version')->toArray();

   $preguntas = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {$query->where('formato', 1);})->get()->pluck('pregunta')->unique();
   $preguntasHabito = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {$query->where('formato', 2);})->get()->pluck('pregunta')->unique();
   $preguntasInteligencia = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {$query->where('formato', 3);})->get()->pluck('pregunta')->unique();


   $respuestas = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {$query->where('formato', 1);})->get();
   $respuestasHabitos = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {$query->where('formato', 2);})->get();
   $respuestasInteligencia = Respuesta::with('pregunta')->whereHas('pregunta', function ($query) {$query->where('formato', 3);})->get();


    $Evaluacion = FormatoEvaluacion::where('formato', 1)->where('user_id', $user->id)->get();
    $EvaluacionHabitos = FormatoEvaluacion::where('formato', 2)->where('user_id', $user->id)->get();
    $EvaluacionInteligencia  = FormatoEvaluacion::where('formato', 3)->where('user_id', $user->id)->get();

   return Inertia::render("Academico/Observacion", [
       'titulo'      => 'Observaciones',
       'Academico'    => $academicos,
       'Habito'    => $habitos,
       'Inteligencia'    => $inteligencias,
       
       'grupo'        => $grupo,   
       'grupoHabito'        => $grupohabitos, 
       'grupoInteligencia'        => $grupointeligencia, 

       'versions' => $versions,
       'versionHabito' => $versionHabito,
       'versionInteligencia' => $versionInteligencia,

       'preguntas'      => $preguntas,  
       'preguntasHabito'      => $preguntasHabito,  
       'preguntasInteligencia'      => $preguntasInteligencia,  
       
       'respuestas'      => $respuestas,  
       'respuestasHabito'      => $respuestasHabitos,  
       'respuestasInteligencia'      => $respuestasInteligencia,  

       'Evaluacion'    => $Evaluacion,
       'EvaluacionHabito'    => $EvaluacionHabitos,
       'EvaluacionInteligencia'    => $EvaluacionInteligencia,

       'routeName'      => $this->routeName,
       'loadingResults' => false
   ]);
   }

    //evaluacionAcademico
    public function create($version)
    {
        
        $preguntas = Pregunta::where('version', $version)->get();
        
        $periodo =Periodo::all();
        $usuarios = User::all();
        $Grupo=Grupo::all();
        $user = auth()->user();
        $existeAcademico = Academico::where('user_id', $user->id)
                                ->where('version', $version)
                                ->where('formato', 1)
                                ->exists();
         if ($existeAcademico) {
            return redirect()->route('academico.index')->with('error', 'Ya has constestado este formato.');
            }
        return Inertia::render("Academico/Create", [
            'titulo'      => 'Analisis',
            'routeName'      => $this->routeName,
            'preguntas'      => $preguntas,
            'periodo' => $periodo,
            'grupo'   => $Grupo,
            'version' => $version,
            'usuarios' => $usuarios,
        ]);
    }

    
    public function store(StoreAcademicoRequest $request)
    {

        $user = auth()->user();
        $profesor = User::find($request->input('profesor_id'))->profesor;
        $periodo = Periodo::find($request->input('periodo_id'));
        $grupo = Grupo::find($request->input('grupo_id'));
        Academico::create([
            'user_id' => $user->id,
            'matricula' => $request->input('matricula'),   
            'grupo_id' => $grupo->id,
            'profesor_id' => $profesor->id,
            'periodo_id' => $periodo->id,
            'materia_recursar' => $request->input('materia_recursar'),
            'estatus' => 1,
            'version' => $request->input('version'),
            'formato' => $request->input('formato'),
            ]);

            $respuestas = $request->input('respuestas');

            if (!is_null($respuestas) && is_array($respuestas)) {
                foreach ($respuestas as $pregunta_id => $respuesta) {
                    // Verifica si la respuesta no es nula antes de guardarla
                    if (!is_null($respuesta) && $respuesta !== '') {
                        Respuesta::create([
                            'respuesta' => $respuesta,
                            'user_id' => $user->id,
                            'pregunta_id' => $pregunta_id,
                        ]);
                    }
                }
            }
        
        
            return redirect()->route("academico.index")->with('message', ' generado con éxito');
    }

    
    public function show(Academico $academico)
    {
        //
    }

    public function edit($id, $version)
    {
        $user = Auth::user();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) use ($version) {
            $query->where('formato', 1);
            $query->where('version', $version);
        })->get();

        $Academico= Academico::find($id);
        $preguntas = $respuestas->pluck('pregunta')->unique();
        $profesor = $Academico->profesor_id;
        

        $usuarioProfesor = User::whereHas('profesor', function ($query) use ($profesor) {
            $query->where('id', $profesor);
        })->first();
        
      
        $periodo = Periodo::all();
        $grupo = Grupo::all();
        $usuarios = User::all();
        return Inertia::render("Academico/Edit", [
            'titulo'      => 'Modificar formulario',
            'Academico'    => $Academico,
            'respuestas'     => $respuestas,
            'grupo'         =>$grupo,
            'preguntas'      => $preguntas,  
            'periodo' =>$periodo,
            'usuarios'      =>$usuarios,
            'profesor'      =>$usuarioProfesor->id,
            'routeName'      => $this->routeName,
        ]);
    }

    public function update(UpdateAcademicoRequest $request,$id)
    {
        dd("hola");
        $user = Auth::user();

        $profesor = User::find($request->input('profesor_id'))->profesor;
        
        $Academico = Academico::find($id);
        $Academico->update([
            'matricula' => $request->input('matricula'),
            'grupo_id' => $request->input('grupo_id'),
            'materia_recursar' => $request->input('materia_recursar'),
            'status' => $request->input('status'),
            'version' => $request->input('version'),
            'formato' => $request->input('formato'),
            'periodo_id' => $request->input('periodo_id'),
            'profesor_id' => $profesor->id, 
            
        ]);


        
        
        $respuestasUsuario = Respuesta::where('user_id', $user->id)->get();
        foreach ($request->input('respuestas') as $respuestaData) {
            // Accede a los datos de respuesta y pregunta
            $preguntaId = $respuestaData['pregunta']['id'];
            $respuestaValor = $respuestaData['respuesta'];
    
            // Busca la respuesta existente para esa pregunta y ese usuario
            $respuestaExistente = $respuestasUsuario->firstWhere('pregunta_id', $preguntaId);
    
            if ($respuestaExistente) {
                // Si la respuesta existe, actualiza el valor
                $respuestaExistente->respuesta = $respuestaValor;
                $respuestaExistente->save();
            } 
        
        } 
        return redirect()->route("academico.index")->with('message', 'Formulario actualizado correctamente!');

    
}

    public function destroy($id)
    {
        $Academico = Academico::find($id);
        $Academico->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Materia eliminada con éxito');

    }
}
