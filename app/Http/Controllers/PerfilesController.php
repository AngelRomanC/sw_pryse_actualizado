<?php

namespace App\Http\Controllers;

use App\Models\Perfiles;
use App\Http\Requests\StorePerfilesRequest;
use App\Http\Requests\UpdatePerfilesRequest;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PerfilesController extends Controller
{
    protected string $routeName;
    protected string $source;
    protected string $module = 'perfiles';
    protected Role $model;

    public function __construct()
    {
        $this->routeName = "perfiles.";
        $this->source    = "Security/Roles/";
        $this->model     = new Role();
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
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',    'LIKE', "%$search%");
                $query->orWhere('description', 'LIKE', "%$search%");
            }
        })->paginate(5)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'title'          => 'Gestión de Roles',
            'records'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
            'status'         => (bool) $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render("{$this->source}Create", [
            'title'    => 'Agregar Roles',
            'routeName'      => $this->routeName,
            'modulos'  => Module::orderBy('key')->get(['id', 'name', 'description', 'key']),
            'permisos' => Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerfilesRequest $request)
    {
        $perfil = Role::create($request->validated());
        $permisos = Permission::whereIn('id', $request->permisos)->get();
        $perfil->syncPermissions($permisos);
        return redirect()->route("{$this->routeName}index")->with('success', 'Rol creado con éxito!');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $perfiles)
    {
        return Inertia::render("{$this->source}Edit", [
            'title'    => 'Editar Roles.',
            'perfil'   => $perfiles->load('permissions:id,name,description,module_key'),
            'modules'  => Module::orderBy('key')->get(['id', 'name', 'description', 'key']),
            'permisos' => Permission::get(['id', 'name', 'description', 'module_key'])->groupBy('module_key')->toArray(),
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerfilesRequest $request, Role $perfiles)
    {
        $perfiles->update($request->validated());
        $permisos = Permission::whereIn('id', $request->permisos)->get();
        $perfiles->syncPermissions($permisos);
        Cache::forget("profile.{$perfiles->id}");
        return redirect()->route("{$this->routeName}index")->with('success', 'Rol modificado con éxito!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $perfiles)
    {
        Cache::forget("profile.{$perfiles->id}");
        $perfiles->delete();
        return redirect()->route("{$this->routeName}index")->with('success', 'Rol eliminado con éxito!');
    }
}
