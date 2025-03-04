<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Http\Requests\StoreMateriaRequest;
use App\Http\Requests\UpdateMateriaRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class MateriaController extends Controller
{
    
    private Materia $model;
    private string $routeName;
    private string $source;
    private string $module = 'materia';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Materia/';
        $this->model = new Materia();
        $this->routeName = 'materia.';

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']);
    }
    public function index(Request $request): Response 
    {
        $Materia = $this->model;
        $Materia = $Materia->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(7)->withQueryString();

        return Inertia::render("Materia/Index", [
            'titulo'      => 'Catalogo de materia de la carrera de Inginieria de Tecnologías de la Información',
            'Materia'    => $Materia, //retornamos al index de vue
            'routeName'      => $this->routeName, //Nombre de la ruta para editar registros.
            'loadingResults' => false //Indica si los resultados están cargando (booleano)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Materia/Create", [
            'titulo'      => 'Crear Nueva Materia',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMateriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMateriaRequest $request)
    {
        Materia::create([
            'nombre' => $request->input('nombre'),
            'clave' => $request->input('clave'),
            'cuatrimestre' => $request->input('cuatrimestre'),
            'tipo' => $request->input('tipo'),
            'No_horas_presenciales' => $request->input('No_horas_presenciales'),
            'No_horas_no_presenciales' => $request->input('No_horas_no_presenciales'),
            'periodo' => $request->input('periodo'),
            'nivel' => $request->input('nivel'),
            'status'=> $request->input('status'),
        ]);
        return redirect()->route("materia.index")->with('message', 'materia generado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $Materia= Materia::find($id);
        return Inertia::render("Materia/Edit", [
            'titulo'      => 'Modificar materia',
            'Materia'    => $Materia,
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMateriaRequest  $request
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */ 
    public function update(UpdateMateriaRequest $request,$id)
    {
        $Materia = Materia::find($id);
        $Materia->update($request->all());
        return redirect()->route("materia.index")->with('message', 'Materia actualizado correctamente!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $Materia = Materia::find($id);
        $Materia->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Materia eliminada con éxito');

    }
}
