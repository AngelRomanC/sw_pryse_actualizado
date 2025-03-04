<?php

use App\Http\Controllers\AcademicoController;
use App\Http\Controllers\InteligenciaController;
use App\Http\Controllers\HabitoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AgencyController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\PerfilesController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\GrupoMateriasController;
use App\Http\Controllers\RecursamientoController;
use App\Http\Controllers\ListaRecursamientoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\FormatoEvaluacionController;
use App\Http\Controllers\RespaldoController;

use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PersonaController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/dashboard', function () {

    return Inertia::render('Dashboard', [
        'users' => User::all(),

    ]);
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Seguridad
    Route::resource('module', ModuleController::class)->parameters(['module' => 'module']);
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('perfiles', PerfilesController::class)->parameters(['perfiles' => 'perfiles']);
    Route::resource('materia', controller: MateriaController::class)->names('materia');

    //Usuarios
    Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'usuarios']);
    Route::get('/perfil', [UserController::class, 'perfil'])->name('usuarios.perfil');
    Route::post('actualizarPerfil', [UserController::class, 'updatePerfil'])->name('usuarios.update-perfil');

    //Profesor
    Route::resource('profesor', ProfesorController::class)->parameters(['profesor' => 'profesor']);
    //Alumno
    Route::resource('alumno', AlumnoController::class)->parameters(['alumno' => 'alumno']);
    //Grupo    
    Route::resource('grupo', GrupoController::class)->names('grupo');
    Route::get('/grupos/{id}/assign-group', [GrupoController::class, 'assignGroupView'])->name('grupos.assign-group.view');
    Route::post('/grupo/{id}/remove-alumno/{userId}', [GrupoController::class, 'removeAlumno'])->name('grupo.remove-alumno');
    Route::post('/gruposAsignacion', [GrupoController::class, 'assignAlumno'])->name('grupos.assign-group.post');
    //Periodo
    Route::resource('periodo', PeriodoController::class)->names('periodo');

    //Academico
    Route::resource('academico', AcademicoController::class)->names('academico');
    Route::get('academico/create/{version}', [AcademicoController::class, 'create'])->name('academico.create');
    Route::get('academico/{id}/edit/{version}', [AcademicoController::class, 'edit'])->name('academico.edit');
    Route::get('observaciones', [AcademicoController::class, 'observacion'])->name('academico.observacion');

    //Habito 
    Route::resource('habito', HabitoController::class)->names('habito');
    Route::get('habito/create/{version}', [HabitoController::class, 'create'])->name('habito.create');
    Route::get('habito/{id}/edit/{version}', [HabitoController::class, 'edit'])->name('habito.edit');

    //Inteligencia 
    Route::resource('inteligencia', InteligenciaController::class)->names('inteligencia');
    Route::get('inteligencia/create/{version}', [InteligenciaController::class, 'create'])->name('inteligencia.create');
    Route::get('inteligencia/{id}/edit/{version}', [InteligenciaController::class, 'edit'])->name('inteligencia.edit');

    //Pregunta 
    Route::resource('pregunta', PreguntaController::class)->parameters(['pregunta' => 'pregunta']);

    //Habilitar versiones
    Route::get('pregunta/{id}/version/{version_id}', [PreguntaController::class, 'crearnuevapregunta'])->name('pregunta.agregar-pregunta');
    Route::post('pregunta/crear', [PreguntaController::class, 'storepregunta'])->name('pregunta.store-pregunta');
    Route::get('habilitar', [PreguntaController::class, 'habilitar'])->name('pregunta.habilitar');
    Route::get('pregunta/{formato_id}/version/{version_id}/estatus/{estatus}/grupo/{grupo_id}', [PreguntaController::class, 'habilitarFormulario'])->name('pregunta.habilitar-formulario');
    Route::get('AnalisisPreguntas', [PreguntaController::class, 'gestionAnalisis'])->name('pregunta.academico');
    Route::get('HabitoPreguntas', [PreguntaController::class, 'gestionHabito'])->name('pregunta.habito');
    Route::get('InteligenciaPreguntas', [PreguntaController::class, 'gestionInteligencia'])->name('pregunta.inteligencia');

    //Gestion de grupo 
    Route::resource('grupomaterias', GrupoMateriasController::class)->parameters(['grupomaterias' => 'grupomaterias']);
    //Publicacion de recursamientos disponibles 
    Route::resource('recursamiento', RecursamientoController::class)->parameters(['recursamiento' => 'recursamiento']);
    //asignar estudiantes a grupo
    Route::get('/grupos/{id}/assign-group', [GrupoController::class, 'assignGroupView'])->name('grupos.assign-group.view');
    Route::post('/grupo/{id}/remove-alumno/{userId}', [GrupoController::class, 'removeAlumno'])->name('grupo.remove-alumno');
    Route::post('/gruposAsignacion', [GrupoController::class, 'assignAlumno'])->name('grupos.assign-group.post');

    Route::resource('lista', ListaRecursamientoController::class)->parameters(['lista' => 'lista']);
    Route::get('/lista/{id}/assign-Alumno', [ListaRecursamientoController::class, 'assignAlumnoRecursamiento'])->name('lista.assign-lista.view'); //aqui meto el event para notificacion
    Route::post('/lista/{id}/eliminar-Alumno/{userId}', [ListaRecursamientoController::class, 'eliminarAlumno'])->name('lista.eliminar-alumno');

    Route::resource('encuesta', EncuestaController::class)->parameters(['encuesta' => 'encuesta']);
    Route::get('encuesta/create/{materia_id}', [EncuestaController::class, 'create'])->name('encuesta.create');

    Route::resource('evaluacion', FormatoEvaluacionController::class)->parameters(['evaluacion' => 'evaluacion']);
    Route::get('evaluacionHabitos', [FormatoEvaluacionController::class, 'evaluacionHabito'])->name('evaluacion.habito');
    Route::get('evaluacionAcademicos', [FormatoEvaluacionController::class, 'evaluacionAcademico'])->name('evaluacion.academico');
    Route::get('evaluacionInteligencias', [FormatoEvaluacionController::class, 'evaluacionInteligencia'])->name('evaluacion.inteligencia');

    Route::resource('recursamiento_copy', RecursamientoController::class)->parameters(['recursamiento_copy' => 'recursamiento_copy']);

    Route::resource('respaldo', RespaldoController::class)->parameters(['respaldo' => 'respaldo']);
    Route::get('respaldo-restauracion/{filename}', [RespaldoController::class, 'restaurarRespaldo'])->name('restaurarRespaldo');
    Route::get('respaldo-descarga/{filename}', [RespaldoController::class, 'descargaRespaldo'])->name('descargaRespaldo');
    Route::get('respaldo-eliminar/{filename}', [RespaldoController::class, 'eliminarRespaldo'])->name('eliminarRespaldo');

    //Notificaciones 


    //Route::get('/notificaciones', [NotificationController::class, 'index']);
    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notifications.index');
    Route::put('/notificaciones/{id}/marcar-como-leida', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::delete('/notificaciones/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notificaciones/count-no-leidas', [NotificationController::class, 'NotificationCount'])->name('notifications.unreadCount');

    //Crear Personas 
    Route::resource('persona', PersonaController::class);


    //Route::resource('documento', controller: DocumentoController::class);
    Route::resource('documento', DocumentoController::class);

    // Route::resource('documento/show', DocumentoController::class);
    //Route::get('documento/{id}/descargar', [DocumentoController::class, 'download'])->name('documento.download');

    //Route::post('documento/{id}', [DocumentoController::class, 'store']);



});

require __DIR__ . '/auth.php';
