<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recursamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'periodo_id',
        'profesor_id',
        'horarios',
        'cupo',
        'estatus',
        ];

        public function listaRecursamientos()
{
    return $this->belongsToMany(ListaRecursamiento::class, 'lista_recursamientos', 'recursamiento_id', 'user_id');
}

public function materia()
{
    return $this->belongsTo(Materia::class, 'materia_id');
}

public function periodo()
{
    return $this->belongsTo(Periodo::class, 'periodo_id');
}

public function profesor()
{
    return $this->belongsTo(Profesor::class, 'profesor_id');
}

public function users()
    {
        return $this->belongsToMany(User::class, 'lista_recursamientos');
    }

    
    public function lista_recursamientos()
    {
        return $this->hasMany(ListaRecursamiento::class, 'recursamiento_id');
    }
}
