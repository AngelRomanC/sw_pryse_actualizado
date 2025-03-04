<?php

namespace App\Http\Controllers;

use App\Models\Respuesta;
use App\Http\Requests\StoreRespuestaRequest;
use App\Http\Requests\UpdateRespuestaRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class RespuestaController extends Controller
{
    private Respuesta $model;
    private string $routeName;
    private string $source;
    private string $module = 'respuesta';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Respuesta/';
        $this->model = new Respuesta();
        $this->routeName = 'respuesta.';

        
    }
    public function index(Request $request): Response

    {
        $Respuesta = $this->model;
        $Respuesta = $Respuesta->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(10)->withQueryString();

        return Inertia::render("Respuesta/Index", [
            'titulo'      => 'Formatos',
            'Respuesta'    => $Respuesta,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Respuesta/Create", [
            'titulo'      => 'Respuesta',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRespuestaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRespuestaRequest $request)
    {
        Respuesta::create([
            'respuesta' => $request->input('respuesta'),
            'user_id' => $request->input('user_id'),
            'pregunta_id' => $request->input('pregunta_id'),
        ]);
        return redirect()->route("respuesta.index")->with('message', 'respuesta generado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Respuesta  $respuesta
     * @return \Illuminate\Http\Response
     */
    public function show(Respuesta $respuesta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Respuesta  $respuesta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Respuesta = Respuesta::find($id);
        return Inertia::render("Respuesta/Edit", [
            'titulo'      => 'Modificar materia',
            'Respuesta'    => $Respuesta,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRespuestaRequest  $request
     * @param  \App\Models\Respuesta  $respuesta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRespuestaRequest $request,  $id)
    {
        $Respuesta = Respuesta::find($id);
        $Respuesta->update($request->all());
        return redirect()->route("respuesta.index")->with('message', 'Respuesta actualizado correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Respuesta  $respuesta
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $Respuesta = Respuesta::find($id);
        $Respuesta->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Respuesta eliminada con éxito');

    }
}
