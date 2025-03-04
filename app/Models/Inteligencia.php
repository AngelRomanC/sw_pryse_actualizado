<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inteligencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'matricula',
        'grupo_id',
        'profesor_id',
        'periodo_id',
        'formato',
        'version',
        'estatus'
      ];

      public function user() {
        return $this->belongsTo(User::class);
    }
       public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }
       public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'grupo_id');
    }
}
