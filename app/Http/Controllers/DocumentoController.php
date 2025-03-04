<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar todos los documentos del usuario (los documentos de las personas que ha registrado)
    public function index()
    {
        // Obtener las personas con sus documentos
        $personas = Persona::where('user_id', auth()->id())
            ->with('documentos') // Cargar los documentos relacionados
            ->paginate(8);

        return Inertia::render("Documento/Index", [
            'personas' => $personas, // Pasar las personas con sus documentos a la vista
        ]);
    }

    // Mostrar el formulario para crear un nuevo documento
public function create()
{
    // Obtener las personas que no tienen documentos
    $personas = Persona::where('user_id', auth()->id())
        ->whereDoesntHave('documentos') // Filtrar solo las personas sin documentos
        ->get();

    return Inertia::render("Documento/Create", [
        'personas' => $personas,
    ]);
}


    // Almacenar el nuevo documento
    public function store(Request $request)
    {


        // Validación de archivos
        $validated = $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'doc_curp' => 'nullable|file|mimes:pdf|max:10240',
            'doc_rfc' => 'nullable|file|mimes:pdf|max:10240',
            'acta_nacimiento' => 'nullable|file|mimes:pdf|max:10240',
            'doc_cuip' => 'nullable|file|mimes:pdf|max:10240',
            'ine' => 'nullable|file|mimes:pdf|max:10240',
            'cartilla_militar' => 'nullable|file|mimes:pdf|max:10240',
            'comprobante_domicilio' => 'nullable|file|mimes:pdf|max:10240',
            'doc_nss' => 'nullable|file|mimes:pdf|max:10240',
            'firma_digital' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        // Guardar los archivos y sus rutas
        $documentoData = ['persona_id' => $validated['persona_id']];

        foreach ($validated as $key => $file) {
            if ($request->hasFile($key)) {
                $documentoData[$key] = $request->file($key)->store('documentos', 'public');
            }
        }
        logger('Archivos recibidos:', $request->allFiles());

        // Crear el documento
        Documento::create($documentoData);

        return redirect()->route('documento.index')->with('success', 'Documento guardado exitosamente');
    }

    // Mostrar el formulario para editar un documento


    public function edit(Documento $documento)
    {
        // Depuración: Verificar el documento recibido
        // logger('Documento recibido:', ['documento' => $documento]);


        // Si el documento está vacío, redirigir con un mensaje de error
        if (!$documento->exists) {
            logger('Documento no encontrado en la base de datos.');
            return redirect()->route('documento.index')->with('error', 'Documento no encontrado.');
        }

        // Asegurar que la relación 'persona' esté cargada
        $documento->load('persona');

        if (!$documento->persona) {
            return redirect()->route('documento.index')->with('error', 'Este documento no tiene una persona asociada.');
        }

        if ($documento->persona->user_id != auth()->id()) {
            return redirect()->route('documento.index')->with('error', 'No tienes permiso para editar este documento.');
        }

        // Obtener las personas registradas por el usuario autenticado
        $personas = Persona::where('user_id', auth()->id())->get();

        // Pasar el documento y las personas a la vista
        return Inertia::render('Documento/Edit', [
            'documento' => $documento,
            'personas' => $personas,
        ]);
    }

    // Actualizar un documento
    public function update(Request $request, Documento $documento)
    {
        // Verificar permisos
        if ($documento->persona->user_id != auth()->id()) {
            return redirect()->route('documento.index')->with('error', 'No tienes permiso para actualizar este documento.');
        }
    
        // Validar los archivos
        $validated = $request->validate([
            'doc_curp' => 'nullable|file|mimes:pdf|max:10240',
            'doc_rfc' => 'nullable|file|mimes:pdf|max:10240',
            'acta_nacimiento' => 'nullable|file|mimes:pdf|max:10240',
            'doc_cuip' => 'nullable|file|mimes:pdf|max:10240',
            'ine' => 'nullable|file|mimes:pdf|max:10240',
            'cartilla_militar' => 'nullable|file|mimes:pdf|max:10240',
            'comprobante_domicilio' => 'nullable|file|mimes:pdf|max:10240',
            'doc_nss' => 'nullable|file|mimes:pdf|max:10240',
            'firma_digital' => 'nullable|file|mimes:pdf|max:10240',
        ]);
    
        // Depuración: Verificar archivos recibidos
        logger('Archivos recibidos:', $request->allFiles());
    
        // Usar una transacción para asegurar la consistencia de la base de datos
        DB::transaction(function () use ($request, $documento, $validated) {
            foreach ($validated as $key => $file) {
                // Depuración: Verificar si el campo tiene un archivo
                logger("Verificando campo: $key", ['hasFile' => $request->hasFile($key)]);
    
                // Solo actualizar si se ha subido un archivo para este campo
                if ($request->hasFile($key)) {
                    logger("Archivo detectado en campo: $key");
    
                    // Eliminar el archivo anterior si existe
                    if ($documento->$key && Storage::exists('public/' . $documento->$key)) {
                        logger('Archivo eliminado:', ['public/' . $documento->$key]);
                        Storage::delete('public/' . $documento->$key);
                    }
    
                    // Guardar el nuevo archivo
                    $documento->$key = $request->file($key)->store('documentos', 'public');
                    logger('Archivo guardado:', [$key => $documento->$key]);
                }
            }
    
            // Guardar los cambios en el documento
            $documento->save();
            logger('Documento actualizado:', $documento->toArray());
        });
    
        return redirect()->route('documento.index')->with('success', 'Documento actualizado exitosamente.');
       //return Inertia::location(route('documento.index'));
       //return Inertia::location(route('documento.index'))->with('success', 'Documento eliminado exitosamente');


    }
    // Eliminar un documento
    public function destroy(Documento $documento)
    {
        // Verificar permisos
        if ($documento->persona->user_id != auth()->id()) {
            return redirect()->route('documento.index')->with('error', 'No tienes permiso para eliminar este documento.');
        }
    
        // Eliminar los archivos asociados
        $camposArchivo = [
            'doc_curp', 'doc_rfc', 'acta_nacimiento', 'doc_cuip', 'ine', 
            'cartilla_militar', 'comprobante_domicilio', 'doc_nss', 'firma_digital'
        ];
    
        foreach ($camposArchivo as $campo) {
            if ($documento->$campo && Storage::exists('public/' . $documento->$campo)) {
                Storage::delete('public/' . $documento->$campo);
            }
        }
    
        // Eliminar el documento
        try {
            $documento->delete();
            return redirect()->route('documento.index')->with('success', 'Documento eliminado exitosamente');
        } catch (\Exception $e) {
            // Manejar errores (por ejemplo, restricciones de clave foránea)
            return redirect()->route('documento.index')->with('error', 'No se pudo eliminar el documento: ' . $e->getMessage());
        }
    }
}
