<?php

namespace App\Listeners;

use App\Notifications\RecursamientoNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User; //agregar usuarios
use Illuminate\Support\Facades\Notification;// agregar




class RecursamientoListener
{
    /**
     * Create the event listener.
     */
    //public $recursamiento;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
      /*  User::all()
        ->except($recursamiento->user_id)
        ->each(function(User $user) use ($recursamiento){
            $user->notify(new RecursamientoNotification($recursamiento));
        });
        */
    /*    User::all()
        ->except($event-> recursamiento->user_id)
        ->each (function (User $user) use ($event){        
          Notification::send($user, new RecursamientoNotification($event->recursamiento));


        });  */
        User::whereIn('role', [ 'Alumno'])  //Mandamos la nnotifiaccion solo a los alumnos 
    ->get()
    ->each(function (User $user) use ($event) {        
        Notification::send($user, new RecursamientoNotification($event->recursamiento));
    });

 
    }
}
