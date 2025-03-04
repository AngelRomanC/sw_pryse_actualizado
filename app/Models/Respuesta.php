<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    protected $fillable = [
        'respuesta',
        'user_id',
        'pregunta_id',
       ];
       // En el modelo Respuesta
public function pregunta()
{
    return $this->belongsTo(Pregunta::class);
}
public function user()
    {
        return $this->belongsTo(User::class);
    }

}
