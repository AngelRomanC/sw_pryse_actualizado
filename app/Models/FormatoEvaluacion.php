<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatoEvaluacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'respuesta',
        'formato',
        'version',
        'user_id'
       ];
}
