<?php

namespace App\Http\Controllers;

use App\Models\EstadoFormatos;
use App\Http\Requests\StoreEstadoFormatosRequest;
use App\Http\Requests\UpdateEstadoFormatosRequest;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class EstadoFormatosController extends Controller
{
    
    private EstadoFormatos $model;
    private string $routeName;
    private string $source;
    private string $module = 'estadoformato';

    public function __construct()
    {
        $this->middleware('auth');
        $this->source = 'EstadoFormato/';
        $this->model = new EstadoFormatos();
        $this->routeName = 'estadoformato.';
    }

    public function index(Request $request): Response
    {
        $Formato = $this->model;
        $Formato = $Formato->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
                $query->orWhere('status', 'LIKE', "%$search%");
            }
        })->paginate(7)->withQueryString();

        return Inertia::render("Encuesta/Index", [
            'titulo'      => 'Encuestas de recursamiento',
            'Formato'    => $Formato,
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    
    public function create()
    {
        //
    }

    
    public function store(StoreEstadoFormatosRequest $request)
    {
        //
    }

    
    public function show(EstadoFormatos $estadoFormatos)
    {
        //
    }

    
    public function edit(EstadoFormatos $estadoFormatos)
    {
        //
    }

    
    public function update(UpdateEstadoFormatosRequest $request, EstadoFormatos $estadoFormatos)
    {
        //
    }

    
    public function destroy(EstadoFormatos $estadoFormatos)
    {
        //
    }
}
