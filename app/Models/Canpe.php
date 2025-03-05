<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canpe extends Model
{
    use HasFactory;
    protected $fillable = [
        'persona_id',
        'registrado_canpe',
        'estatus_canpe',
        'correo_canpe',
        'password_canpe',
        'inaccesible_canpe'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
