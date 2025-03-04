<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Inteligencia;
use App\Http\Requests\StoreInteligenciaRequest;
use App\Http\Requests\UpdateInteligenciaRequest;
use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Grupo_Alumnos;
use App\Models\Habilitarversiones;
use App\Models\Periodo;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use App\Models\Pregunta;
use App\Models\Profesor;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class InteligenciaController extends Controller
{
    private Inteligencia $model;
    private string $routeName;
    private string $source;
    private string $module = 'inteligencia';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Inteligencia/';
        $this->model = new Inteligencia();
        $this->routeName = 'inteligencia.';

   }
   
   public function index(Request $request): Response

   {
    $user = Auth::user();
    $inteligenciaId = $user->inteligencia ? $user->inteligencia->id : null;
    $inteligencia = $user->inteligencia;
    $inteligencias = Inteligencia::where('user_id', $user->id)->get();
    $profesor = $inteligencia ? Profesor::find($inteligencia->profesor_id) : null;
    $usuarioProfesor = $profesor ? User::find($profesor->user_id) : null;
    $periodo = $inteligencia ? Periodo::find($inteligencia->periodo_id) : null;
    $grupo = $inteligencia ? Grupo::find($inteligencia->grupo_id) : null;
        $versions = DB::table('preguntas')
        ->where('estatus', 1)
        ->where('formato', 3)
        ->distinct()->pluck('version')->toArray();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 3)
            ->where('estatus', 1);
        })->get();
        $preguntas = $respuestas->pluck('pregunta')->unique();

        $alumnoId = Alumno::where('user_id', $user->id)->first(); 
        $alumnoId = $alumnoId ->id;
        if($alumnoId){
        $grupoAlumno = Grupo_Alumnos::where('alumno_id', $alumnoId)->first();
        $registros = Habilitarversiones::where('grupo_alumno', $grupoAlumno->id)->where('formato',3)->where('estatus',1)->get();
        
        }
       return Inertia::render("Inteligencia/Index", [
           'titulo'      => 'Formato de inteligencias múltiples',
           'routeName'      => $this->routeName,
           'Inteligencia'      => $inteligencias, 
           'inteligenciaId'      => $inteligenciaId,   
           'preguntas' => $preguntas,
           'respuestas' => $respuestas,
           'versions'    => $versions,
           'profesor'   => $usuarioProfesor,
           'periodo'    => $periodo,
           'grupo'     =>$grupo,
           'version_habilitada' => $registros,
           'loadingResults' => false
       ]);
   }

    
    public function create($version)
    {
        $user = auth()->user();
        $existeHabito = Inteligencia::where('user_id', $user->id)
        ->where('version', $version)
        ->where('formato', 3)
        ->exists();
        if ($existeHabito) {
            return redirect()->route('inteligencia.index')->with('error', 'Ya has constestado este formato.');
        }
        $preguntas = Pregunta::where('version', $version)
        ->where('formato', 3)
        ->get();
        $usuarios = User::all();
        $periodo = Periodo::all();
        $Grupo=Grupo::all();

        return Inertia::render("Inteligencia/Create", [
            'titulo'      => 'Formato de inteligencias multiples',
            'routeName'      => $this->routeName,
            'preguntas'      => $preguntas,  
            'usuarios'       =>$usuarios,
            'periodo'        =>$periodo,
            'version'        =>$version,
            'grupo'   => $Grupo,
        ]);
    }

    
    public function store(StoreInteligenciaRequest $request)
    {
        $user = auth()->user();
        $profesor = User::find($request->input('profesor_id'))->profesor;
        $periodo = Periodo::find($request->input('periodo_id'));
        $grupo = Grupo::find($request->input('grupo_id'));
        Inteligencia::create([
            'user_id'     => $user->id,
            'matricula'   => $request->input('matricula'),
            'grupo_id' => $grupo->id,
            'formato'     => $request->input('formato'),
            'profesor_id' => $profesor->id,
            'periodo_id'  => $periodo->id,
            'version' => $request->input('version'),
            'estatus'     => 1,
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
            return redirect()->route("inteligencia.index")->with('succes', 'grupo generado con éxito');
    }

    public function show(Inteligencia $inteligencia)
    {
    
    }

 
    public function edit($id, $version)
    {
        $user = Auth::user();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) use ($version) {
            $query->where('formato', 3);
            $query->where('version', $version);
        })->get();
        $inteligencia = Inteligencia::find($id);
        $preguntas = $respuestas->pluck('pregunta')->unique();
        $profesor = $inteligencia->profesor_id;
        $usuarioProfesor = User::whereHas('profesor', function ($query) use ($profesor) {
            $query->where('id', $profesor);
        })->first();
        $usuarios = User::all();
        $periodo = Periodo::all();
        $grupo = Grupo::all();
        $inteligencia= Inteligencia::find($id);
        return Inertia::render("Inteligencia/Edit", [
            'titulo'      => 'Modificar formulario ',
            'Inteligencia'    => $inteligencia,
            'respuestas'     => $respuestas,
            'preguntas'      => $preguntas,  
            'version'        => $version,
            'grupo'         =>$grupo,
            'usuarios'       => $usuarios,
            'periodo'        => $periodo,
            'profesor'       =>$usuarioProfesor->id,
            'routeName'      => $this->routeName,
        ]);
    }

 
    public function update(UpdateInteligenciaRequest $request, $id)
    {
        $user = Auth::user();

        $Inteligencia = Inteligencia::find($id);
        $profesor = User::find($request->input('profesor_id'))->profesor;

        $Inteligencia->update([
            'matricula' => $request->input('matricula'),
            'grupo_id' => $request->input('grupo_id'),
            'estatus' => $request->input('estatus'),
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
        return redirect()->route("inteligencia.index")->with('message', 'Formulario actualizado correctamente!');

    
}

   
    public function destroy($id)
    {
        $inteligencia = Inteligencia::find($id);
        $inteligencia->delete();
        return redirect()->route("inteligencia.index")->with('success', 'Formato eliminada con éxito');

    }
}
