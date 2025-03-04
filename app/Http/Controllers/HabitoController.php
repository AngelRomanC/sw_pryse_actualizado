<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Habito;
use App\Http\Requests\StoreHabitoRequest;
use App\Http\Requests\UpdateHabitoRequest;
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

class HabitoController extends Controller
{
    private Habito $model;
    private string $routeName;
    private string $source;
    private string $module = 'habito';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Habito/';
        $this->model = new Habito();
        $this->routeName = 'habito.';
    }

    public function index(Request $request): Response
    {
        $user = Auth::user();
        $habitoId = $user->habito ? $user->habito->id : null;
        $habito = $user->habito;
        
        $habitos = Habito::where('user_id', $user->id)->get();

        $periodo = $habito ? Periodo::find($habito->periodo_id) : null;
        $profesor = $habito ? Profesor::find($habito->profesor_id) : null;
        $usuarioProfesor = $profesor ? User::find($profesor->user_id) : null;
        $grupo = $habito ? Grupo::find($habito->grupo_id) : null;
        $versions = DB::table('preguntas')
            ->where('estatus', 1)
            ->where('formato', 2)
            ->distinct()->pluck('version')->toArray();

        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) {
            $query->where('formato', 2)
            ->where('estatus', 1);
        })->get();
        $alumnoId = Alumno::where('user_id', $user->id)->first();
        $preguntas = $respuestas->pluck('pregunta')->unique();
        $alumnoId = $alumnoId ->id;
        
        if($alumnoId){
        $grupoAlumno = Grupo_Alumnos::where('alumno_id', $alumnoId)->first();
        
        $registros = Habilitarversiones::where('grupo_alumno', $grupoAlumno->id)->where('formato',2)->where('estatus',1)->get();
        
        }

        return Inertia::render("Habito/Index", [
            'titulo'    => 'Formato de habitos de estudio',
            'routeName' => $this->routeName,
            'Habito'    => $habitos,
            'habitoId'  => $habitoId,
            'preguntas' => $preguntas,
            'respuestas' => $respuestas,
            'profesor'  => $usuarioProfesor,
            'version'   => $versions,
            'periodo'   => $periodo,
            'grupo'     =>$grupo,
            'version_habilitada' => $registros,
            'loadingResults' => false
        ]);
    }


    public function create($version)
    {
        $user = auth()->user();

        $existeHabito = Habito::where('user_id', $user->id)
        ->where('version', $version)
        ->where('formato', 2)
        ->exists();
        if ($existeHabito) {
            return redirect()->route('habito.index')->with('error', 'Ya has constestado este formato.');
        }
        $preguntas = Pregunta::where('version', $version)
            ->where('formato', 2)
            ->get();

        $usuarios = User::all();
        $periodo = Periodo::all();
        $Grupo=Grupo::all();
        return Inertia::render("Habito/Create", [
            'titulo'      => 'Habitos de estudio',
            'routeName'   => $this->routeName,
            'preguntas'   => $preguntas,
            'usuarios'    => $usuarios,
            'periodo'     => $periodo,
            'version'     => $version,
            'grupo'   => $Grupo,
            
        ]);
    }


    public function store(StoreHabitoRequest $request)
    {

        $user = auth()->user();
        $profesor = User::find($request->input('profesor_id'))->profesor;
        $periodo = Periodo::find($request->input('periodo_id'));
        $grupo = Grupo::find($request->input('grupo_id'));
        Habito::create([
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

        return redirect()->route("habito.index")->with('message', 'grupo generado con éxito');
    }


    public function show(Habito $habito)
    {
        //
    }


    public function edit($id, $version)
    {
        $user = Auth::user();
        $respuestas = Respuesta::with('pregunta')->where('user_id', $user->id)->whereHas('pregunta', function ($query) use ($version) {
            $query->where('formato', 2);
            $query->where('version', $version);
        })->get();
        $habito = Habito::find($id);
        $preguntas = $respuestas->pluck('pregunta')->unique();
        $profesor = $habito->profesor_id;
        $usuarioProfesor = User::whereHas('profesor', function ($query) use ($profesor) {
            $query->where('id', $profesor);
        })->first();

        $usuarios = User::all();
        $periodo = Periodo::all();
        $grupo = Grupo::all();
        return Inertia::render("Habito/Edit", [
            'titulo'      => 'Modificar formato',
            'habito'       => $habito,
            'respuestas'     => $respuestas,
            'preguntas'      => $preguntas,
            'version'        => $version,
            'usuarios'       => $usuarios,
            'grupo'         =>$grupo,
            'periodo'        => $periodo,
            'profesor'       =>$usuarioProfesor->id,
            'routeName'      => $this->routeName,
        ]);
    }

    public function update(UpdateHabitoRequest $request, $id)
    {
        $habito = Habito::find($id);
        $profesor = User::find($request->input('profesor_id'))->profesor;
        $habito->update([
            'matricula' => $request->input('matricula'),
            'grupo_id' => $request->input('grupo_id'),
            'estatus' => $request->input('estatus'),
            'version' => $request->input('version'),
            'formato' => $request->input('formato'),
            'periodo_id' => $request->input('periodo_id'),
            'profesor_id' => $profesor->id, 
            
        ]);

        $user = Auth::user();
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
        return redirect()->route("habito.index")->with('message', 'Formato actualizado correctamente!');
    }


    public function destroy($id)
    {
        $habito = Habito::find($id);
        $habito->delete();
        return redirect()->route("habito.index")->with('success', 'Formato eliminada con éxito');
    }
}
