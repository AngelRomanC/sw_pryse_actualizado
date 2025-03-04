<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Http\Requests\StoreAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;

use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class AgencyController extends Controller
{
    private Agency $model;
    private string $source;
    private string $routeName;
    private string $module = 'agency';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'Catalogs/Agencies/';
        $this->model = new Agency();
        $this->routeName = 'agency.';

        $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);
    
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $records = Agency::with('users');
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            }
        })->paginate(5);

        return Inertia::render("{$this->source}Index", [
            'agencies'        =>  $records,
            'title'          => 'Gestión de Agencias',
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'title'          => 'Agregar Agencia',
            'routeName'      => $this->routeName
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAgencyRequest $request)
    {
        Agency::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Agencia creada con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Agency $agency)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agency $agency)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'          => 'Editar Agencia',
            'agency'        => $agency,
            'routeName'      => $this->routeName
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAgencyRequest $request, Agency $agency)
    {
        $agency->update($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Agencia modificada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agency $agency)
    {
        $agency->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Agencia eliminada con éxito');
    }
}
