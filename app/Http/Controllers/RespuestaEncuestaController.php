<?php

namespace App\Http\Controllers;

use App\Models\RespuestaEncuesta;
use App\Http\Requests\StoreRespuestaEncuestaRequest;
use App\Http\Requests\UpdateRespuestaEncuestaRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class RespuestaEncuestaController extends Controller
{
    private RespuestaEncuesta $model;
    private string $routeName;
    private string $source;
    private string $module = 'periodo';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'RespuestaEncuesta/';
        $this->model = new RespuestaEncuesta();
        $this->routeName = 'respuestaencuesta.';
    }

    public function index(Request $request): Response
    {
        $RespuestaEncuesta = $this->model;
        $RespuestaEncuesta = $RespuestaEncuesta->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(7)->withQueryString();

        return Inertia::render("EncuestaRespuesta/Index", [
            'titulo'      => 'Encuesta de recursamiento',
            'respuesta'    => $RespuestaEncuesta,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }
 
    public function create()
    {
        return Inertia::render("EncuestaRespuesta/Create",[
            'titulo'      => 'Encuestas de recursamiento',
            'routeName'      => $this->routeName,
        ]);
    }

    public function store(StoreRespuestaEncuestaRequest $request)
    {
        Encuesta::Create([
            'horario'=> $request->input('horario'),
            'profesores'=> $request->input('profesores'),
            'tipo_proyecto' => $request->imput('tipo_proyecto'),
            'dificultad'=> $request->imput('dificultad'),
            'periodo' =>$request->imput('periodo'),
            'estudiantes' =>$request->input('estudiantes'),
        ]);
        return redirect()->route('Encuesta.index');
    }

    
    public function show(RespuestaEncuesta $respuestaEncuesta)
    {
        
    }

   
    public function edit(RespuestaEncuesta $respuestaEncuesta)
    {
        
    }

    
    public function update(UpdateRespuestaEncuestaRequest $request, RespuestaEncuesta $respuestaEncuesta)
    {
       
    }

    public function destroy(RespuestaEncuesta $respuestaEncuesta)
    {
       
    }
}
