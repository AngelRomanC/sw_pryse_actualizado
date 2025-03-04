<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Pregunta;
use App\Http\Requests\StorePreguntaRequest;
use App\Http\Requests\UpdatePreguntaRequest;
use Illuminate\Http\Request;
use App\Models\Academico;
use App\Models\Grupo;
use App\Models\Grupo_Alumnos;
use App\Models\Habilitarversiones;
use App\Models\Habito;
use App\Models\Inteligencia;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Inertia\Inertia;

class PreguntaController extends Controller
{
    private Pregunta $model;
    private string $routeName;
    private string $source;
    private string $module = 'pregunta';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Pregunta/';
        $this->model = new Pregunta();
        $this->routeName = 'pregunta.';

    }
    public function index(Request $request): Response
    {
       

        return Inertia::render("Pregunta/Index", [
            'titulo'      => 'Gestión de formularios', 
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    public function gestionAnalisis(Request $request): Response
    {

       $Pregunta = $this->model;
        $Academico = Academico::all();
       
        $Pregunta = $Pregunta->where('formato', 1)
    ->when($request->search, function ($query, $search) {
        if ($search != '') {
            $query->where('name', 'LIKE', "%$search%");
            $query->orWhere('status', 'LIKE', "%$search%");
        }
    })->paginate(150)->withQueryString();

        $versions = DB::table('preguntas')->where('formato', 1)->distinct()->pluck('version')->toArray(); 
        

        return Inertia::render("Pregunta/Academico", [
            'titulo'      => 'Gestión formulario análisis academico individual',
            'Pregunta'    => $Pregunta,
            'Academico'    => $Academico,
            'routeName'      => $this->routeName,
            'version' => $versions,
            'loadingResults' => false
        ]);
    }

    public function gestionHabito(Request $request): Response
    {
        $Pregunta = $this->model;
        $Academico = Academico::all();
        $version = $request->input('version');
        $Pregunta = $Pregunta->where('formato',2)
        ->when($version, function($query,$version){
            $query->where('version', $version);

        })
        ->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(150)->withQueryString();
        $versions = DB::table('preguntas')->where('formato', 2)->distinct()->pluck('version')->toArray(); // Obtener todas las versiones disponibles
        

        return Inertia::render("Pregunta/Habito", [
            'titulo'      => 'Gestión formulario hábitos de estudio',
            'Pregunta'    => $Pregunta,
            'Academico'    => $Academico,
            'routeName'      => $this->routeName,
            'version' => $versions,
            'loadingResults' => false
        ]);
    }

    public function gestionInteligencia(Request $request): Response
    {
        
        $Pregunta = $this->model;
        $Academico = Academico::all();
        $version = $request->input('version');
        $Pregunta = $Pregunta->where('formato',3)
        ->when($version, function($query,$version){
            $query->where('version', $version);

        })
        ->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(150)->withQueryString();
        $versions = DB::table('preguntas')->where('formato', 3)->distinct()->pluck('version')->toArray(); // Obtener todas las versiones disponibles
        

        return Inertia::render("Pregunta/Inteligencia", [
            'titulo'      => 'Gestión formulario Inteligencias múltiples',
            'Pregunta'    => $Pregunta,
            'Academico'    => $Academico,
            'routeName'      => $this->routeName,
            'version' => $versions,
            'loadingResults' => false
        ]);
    }
    public function habilitar()
    {
        $versionsByFormat = [];
        for ($i = 1; $i <= 3; $i++) {
            $formato = '';
            switch ($i) {
                case 1:
                    $formato = 'Formato Análisis académico individual';
                    break;
                case 2:
                    $formato = 'Formato Hábitos de estudio';
                    break;
                case 3:
                    $formato = 'Formato Inteligencias múltiples';
                    break;
            }
    
            $versionsByFormat[$formato] = DB::table('preguntas')
                                            ->where('formato', $i)
                                            ->distinct()
                                            ->pluck('version')
                                            ->toArray();
        }
        
        $user = Auth::user();
        $grupos = Grupo::whereHas('profesor', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $versionsAcademico= DB::table('preguntas')->where('formato', 1)->distinct()->pluck('version')->toArray();
        $versionsHabito= DB::table('preguntas')->where('formato', 2)->distinct()->pluck('version')->toArray();
        $versionsInteligencia= DB::table('preguntas')->where('formato', 3)->distinct()->pluck('version')->toArray();
       
      
   
        return Inertia::render("Pregunta/habilitar", [
            'titulo'      => 'Habilitar formularios',
            'routeName'      => $this->routeName,
            'versionAcademico'   => $versionsAcademico,
            'versionHabito'   => $versionsHabito,
            'versionInteligencia'   => $versionsInteligencia,
           'grupos'=>   $grupos,

        ]);

    }
    public function habilitarFormulario($formato_id, $version_id, $estatus,$grupo_id)
    {
   
   if ($estatus === 'habilitar') {
    $estatus = 1;
    } 
    if ($estatus === 'deshabilitar') {
        $estatus = 0;
    }
 
       switch ($formato_id) {
           case 'Formato Análisis académico individual':
               $formato_id = 1;
               break;
           case 'Formato Hábitos de estudio':
               $formato_id = 2;
               break;
           case 'Formato Inteligencias múltiples':
               $formato_id = 3;
               break;
           
       }

       $registros = Habilitarversiones::whereHas('grupoAlumno', function($query) use ($grupo_id) {
        $query->where('grupo_id', $grupo_id);
    })
    ->where('formato', $formato_id)
    ->where('version', $version_id)
    ->get();

    foreach ($registros as $registro) {
        $registro->update(['estatus' => $estatus]);
    }
       Grupo::where('id', $grupo_id)
        ->update(['estatus' => $estatus]);
        $preguntas = Pregunta::where('formato', $formato_id)
        ->where('version', $version_id)
        ->get();

        Habito::where('formato', $formato_id)
        ->where('version', $version_id)
        ->update(['estatus' => $estatus]);
        
        Academico::where('formato', $formato_id)
        ->where('version', $version_id)
        ->where('grupo_id', $grupo_id)
        ->update(['estatus' => 0]);

        Inteligencia::where('formato', $formato_id)
        ->where('version', $version_id)
        ->update(['estatus' => $estatus]);
        
        if ($estatus === '1') {
          
            foreach ($preguntas as $pregunta) {
                $pregunta->estatus = 1;
                $pregunta->save();
            }
            return redirect()->route("pregunta.habilitar")->with('success', 'Formulario activado.');

        } elseif ($estatus === '0') {
            foreach ($preguntas as $pregunta) {
                $pregunta->estatus = 0;
                $pregunta->save();
            }
            return redirect()->route("pregunta.habilitar")->with('success', 'Formulario desactivado.');

        } else {
        return redirect()->route("pregunta.habilitar")->with('error', 'Estatus inválido.');
        }

    }
    public function create()
    {
        $versions = DB::table('preguntas')->distinct()->pluck('version')->toArray(); 
        return Inertia::render("Pregunta/Create", [
            'titulo'      => 'Crear nuevo formulario',
            'routeName'      => $this->routeName,
            'version' => $versions,
        ]);
    }

    public function crearnuevapregunta($formato, $version)
    {

        return Inertia::render("Pregunta/createpregunta", [
            'titulo'      => 'Crear nueva pregunta',
            'routeName'      => $this->routeName,
            'version' => $version,
            'formato' =>  $formato,
        ]);
        
        return redirect()->route("pregunta.index");
    }
    public function storepregunta(StorePreguntaRequest $request)
    {
        
        $versionAcademica = DB::table('preguntas')->where('version', $request->version)->where('formato', $request->formato)->orderBy('id') ->first();
       
        Pregunta::create([
            'pregunta' => $request->input('pregunta'),
            'formato' => $request->input('formato'),
            'version' => $request->input('version'),
            'estatus' => $versionAcademica->estatus,
        ]);
        
        if ((int)$request->formato === 1) {
            return redirect()->route("pregunta.academico");
        }
        if ((int)$request->formato === 2) {
            return redirect()->route("pregunta.habito");
        }
        if ((int)$request->formato === 3) {
            return redirect()->route("pregunta.inteligencia");
        }
        
        
    }
    
    public function store(StorePreguntaRequest $request)
    {
        
        
        $grupoAlumno = Grupo_Alumnos::all();
        foreach ($grupoAlumno as $grupoAlumnoId) {
            Habilitarversiones::create([
                'estatus'  => 0,
                'grupo_alumno'  =>  $grupoAlumnoId->id,
                'formato'  => $request->input('formato'),
                'version' => $request->input('version'),
            ]);

        }
        
        $Formato= $request->input('formato');
        $versionAnterior = Pregunta::where('formato', $Formato)
        ->max('version');
        $preguntasVersionAnterior = Pregunta::where('version', $versionAnterior)
            ->where('formato',$Formato )
            ->get();
        foreach ($preguntasVersionAnterior as $pregunta) {
            $nuevaPregunta = new Pregunta([
                'pregunta' => $pregunta->pregunta,
                'formato' => $request->input('formato'),
                'version' => $versionAnterior+1, 
                'estatus'  => $request->input('estatus'), 
            ]);
            $nuevaPregunta->save();
        }

    
        $preguntas = $request->input('preguntas');
        foreach ($preguntas as $pregunta) {
            Pregunta::create([
                'pregunta' => $pregunta['pregunta'],
                'formato' => $request->input('formato'),
                'version' => $versionAnterior+1,
                'estatus'  => $request->input('estatus'), 
            ]);
        }
    
        return redirect()->route("pregunta.index");
    }


    
   
    public function show(Pregunta $pregunta)
    {
        //
    }

   
    public function edit( $id)
    {
        $Pregunta= Pregunta::find($id);
        return Inertia::render("Pregunta/Edit", [
            'titulo'      => 'Modificar pregunta',
            'Pregunta'    => $Pregunta,
            'routeName'      => $this->routeName,
        ]);
    }

    
    public function update(UpdatePreguntaRequest $request, $id)
    {
        $Pregunta= Pregunta::find($id);
        $Pregunta->update($request->all());
        if ($Pregunta->formato === 1){
            return redirect()->route("pregunta.academico")->with('success', 'Pregunta actualizada con éxito');
        }
        if ($Pregunta->formato === 2){
            return redirect()->route("pregunta.habito")->with('success', 'Pregunta actualizada con éxito');
        }
        if ($Pregunta->formato === 3){
            return redirect()->route("pregunta.inteligencia")->with('success', 'Pregunta actualizada con éxito');
        }
    }

        public function destroy( $id)
    {
        $Pregunta = Pregunta::find($id);
        
        $Pregunta->delete();
        if ($Pregunta->formato === 1){
            return redirect()->route("pregunta.academico")->with('success', 'Pregunta eliminada con éxito');
        }
        if ($Pregunta->formato === 2){
            return redirect()->route("pregunta.habito")->with('success', 'Pregunta eliminada con éxito');
        }
        if ($Pregunta->formato === 3){
            return redirect()->route("pregunta.inteligencia")->with('success', 'Pregunta eliminada con éxito');
        }

    }
}
