<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;
    protected $fillable = [
        'horario',
        'profesores',
        'tipo_proyecto',
        'dificultad',
        'estudiantes',
        'user_id',
        'materia_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
