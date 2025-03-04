<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo_Materias extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'grupo_id',
    ];


    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
