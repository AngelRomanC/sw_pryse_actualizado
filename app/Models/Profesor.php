<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Profesor extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = [
        'grado_academico',
        'area',
        'user_id'
       ];
      
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function grupo()
    {
        return $this->hasOne(Grupo::class);
    }
    public function academico()
    {
        return $this->hasMany(Academico::class, 'profesor_id', 'id');
    }
    public function recursamientos()
    {
    return $this->hasMany(Recursamiento::class, 'profesor_id');
    }
    public function profeuser()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
}
