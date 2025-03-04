<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'clave',
        'cuatrimestre',
        'tipo',
        'No_horas_presenciales',
        'No_horas_no_presenciales',
        'periodo',
        'nivel',
         'status'];
         public function grupos()
         {
             return $this->hasMany(Grupo_Materias::class, 'materia_id');
         }

         public function recursamientos()
        {
            return $this->hasMany(Recursamiento::class, 'materia_id');
        }
         

}
