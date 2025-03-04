<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [
        'grado',
        'grupo',
        'profesor_id',
        'estatus',

    ];
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'grupo_alumnos', 'grupo_id', 'alumno_id');
    }
   
    public function grupoMateria()
    {
        return $this->belongsToMany(Materia::class, 'grupo_materias', 'grupo_id', 'materia_id');
    }
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'grupo__materias', 'grupo_id', 'materia_id')
            ->withTimestamps();
    }
    public function gruposRelacionados()
    {
        return $this->belongsToMany(Grupo::class, 'grupo__materias', 'materia_id', 'grupo_id')
            ->withTimestamps();
    }
    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }
    public function grupoAlumnos()
    {
        return $this->hasMany(Grupo_Alumnos::class);
    }
    
}
