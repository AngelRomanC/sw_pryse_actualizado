<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo_Alumnos extends Model
{
    use HasFactory;
    protected $table = 'grupo_alumnos';
    protected $fillable = [
        'alumno_id',
        'grupo_id',
        'estatus',
    ];
   
}
