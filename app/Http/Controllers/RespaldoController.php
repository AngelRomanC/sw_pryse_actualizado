<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;


class RespaldoController extends Controller
{

    private string $source; // Ruta base para las vistas
    private string $routeName; // Prefijo de nombre de ruta
    private string $module = 'respaldo'; // Módulo
    private string $disk = 'local'; // Disco de almacenamiento

    public function __construct()
    {
        $this->middleware('auth'); // Middleware para autenticación
        $this->source = 'Respaldo/'; // Ruta base para las vistas de respaldo
        $this->routeName = 'respaldo.'; // Prefijo de nombre de ruta

        // Middleware para permisos basados en roles
       /* $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);*/
    }
    //
    public function index()
    {
        // Zona horaria
        date_default_timezone_set('America/Mexico_City');

        // Obtener una lista de los archivos de respaldo en la ubicación de almacenamiento
        $files = Storage::disk($this->disk)->files('respaldos');
        $fileMetadata = [];

        foreach ($files as $file) {
            // Obtener tamaño del archivo
            $size = Storage::size($file);
            // Obtener fecha de modificación del archivo
            $lastModified = Storage::lastModified($file);

            // Convertir la fecha de modificación a formato legible            
            $lastModifiedDate = date("Y-m-d-H:i:s", $lastModified);
            
            $fileMetadata[] = [
                // 'ubicacion' => $file,
                'ubicacion' => str_replace("respaldos/", "", $file),
                // 'fecha_modificacion' => $lastModifiedDate,
                'fecha_modificacion' => $lastModifiedDate,

                'size' => round($size / 1048576, 2) . ' MB'
            ];
        }

        // Renderizar la vista con los datos de respaldo
        return Inertia::render("{$this->source}Index", [
            'titulo' => 'Respaldo y recuperación',
            'routeName' => $this->routeName,
            'respaldos' => $fileMetadata,
        ]);
    }

    public function create()
    {
        date_default_timezone_set('America/Mexico_City');
        $date = date("Y-m-d-H-i-s");
        $databaseUser = env('DB_USERNAME'); //se hace referencia al dato 'DB_USERNAME' que se encuentra en el .env
        $databasePassword = env('DB_PASSWORD'); //se hace referencia al dato 'DB_PASSWORD' que se encuentra en el .env
        $databaseName = env('DB_DATABASE'); //se hace referencia al dato 'DB_DATABASE' que se encuentra en el .env
        $backupName = $databaseName . '-' . $date . '.sql'; //se le da el nombre al archivo del respaldo
        $backupPath = storage_path('app/respaldos/'); //se obtiene la ruta total de la carpeta 'backups' en el storage
        // Ejecutar el comando mysqldump utilizando los datos anteriormente extraidos del .env
        $command = "mysqldump --column-statistics=0 --host=localhost --user={$databaseUser} --password={$databasePassword} --databases {$databaseName} > {$backupPath}{$backupName}";
        exec($command);
        Storage::disk('local')->put('respaldos/' . $backupName, file_get_contents($backupPath . $backupName));
        
        // Obtener el tamaño del archivo de la copia de seguridad en bytes
        $backupSize = filesize($backupPath . $backupName);

        $backup = [
            'backupName' => $backupName,
            'disk' => $this->disk,
            'size' => round($backupSize / 1048576, 2),
            'date' => $date
        ];
        // Enviar correo electrónico con los datos del respaldo
        // Mail::to('omjo200846@upemor.edu.mx')->send(new BackupCreated($backup));
        return redirect()->route("{$this->routeName}index")->with('success', 'Respaldo creado!');
    }
    
    public function restaurarRespaldo($filename)
    {
        $filePath = 'respaldos/' . $filename;
        $archivoPath = storage_path('app/' . $filePath);

        if (file_exists($archivoPath)) {
            $sql = file_get_contents($archivoPath);//leemos el contenido del archivo
            DB::unprepared($sql);//esta linea nos sirve para ejecutar el contenido del archivo SQL en la base de datos.
            return redirect()->route("{$this->routeName}index")->with('success', 'El respaldo fue restaurado en la base de datos!');
        } else {
            return redirect()->route("{$this->routeName}index")->with('error', 'No existe el respaldo a eliminar');
        }
    }

    public function descargaRespaldo($filename)
    {
        $file = $filename;

        // Ruta completa del archivo
        $filePath = 'respaldos/' . $filename;
        $archivoPath = storage_path('app/' . $filePath);

        if (file_exists($archivoPath)) {
            return response()->download($archivoPath, $file);
        } else {
            abort(404);
        }
    }

    public function eliminarRespaldo($filename){
        $filePath = 'respaldos/' . $filename;
         $archivoPath = storage_path('app/' . $filePath);
 
         if (file_exists($archivoPath)) {
             Storage::delete($filePath);
             return redirect()->route("{$this->routeName}index")->with('success', 'El respaldo fue eliminado con éxito!');
         } else {
             return redirect()->route("{$this->routeName}index")->with('error', 'No existe el respaldo a eliminar');
         }

    }


}
