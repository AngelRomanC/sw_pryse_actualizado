<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaRecursamiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'recursamiento_id',
       ];
       public function recursamientos()
       {
           return $this->belongsToMany(Recursamiento::class, 'lista_recursamientos', 'user_id', 'recursamiento_id');
       }
       public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function recursamiento()
    {
        return $this->belongsTo(Recursamiento::class);
    }
    
   
}
