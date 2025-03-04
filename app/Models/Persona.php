<?php

namespace App\Models;

use App\Http\Controllers\DocumentoController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento',
        'edad',
        'entidad_nacimiento',
        'rfc',
        'cp',
        'nss',
        'cuip',
        'curp',
        'user_id'

    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'persona_id');
    }
}
