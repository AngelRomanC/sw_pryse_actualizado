<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Documento extends Model
{
    use HasFactory;
    protected $fillable = [

        'persona_id',
        'doc_curp',
        'doc_rfc',
        'acta_nacimiento',
        'doc_cuip',
        'ine',
        'cartilla_militar',
        'comprobante_domicilio',
        'doc_nss',
        'firma_digital',
        'estatus'
    ];

    // Relación con el modelo Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class,'persona_id');
    }
}
