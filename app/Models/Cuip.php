<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuip extends Model
{
    use HasFactory;

    protected $fillable = [
        'persona_id',
        'folio_cuip',
        'fecha_expedicion',
        'estatus_rfc',
        'vigencia_ine',
        'estado_ine',
        'valida_ine'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

}
