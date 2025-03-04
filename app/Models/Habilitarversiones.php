<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilitarversiones extends Model
{
    use HasFactory;
    protected $fillable = [
        'grupo_alumno',
        'formato',
        'version',
        'estatus',
    ];
    public function grupoAlumno()
    {
        return $this->belongsTo(Grupo_Alumnos::class, 'grupo_alumno');
    }
}
