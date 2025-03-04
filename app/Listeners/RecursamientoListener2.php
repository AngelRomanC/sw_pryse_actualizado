<?php

namespace App\Listeners;

use App\Notifications\RecursamientoNotification2;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User; //agregar usuarios
use Illuminate\Support\Facades\Notification; // agregar




class RecursamientoListener2
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
        /*  User::whereIn('role', [ 'Admin','Tutor'])  //Mandamos la nnotifiaccion solo a los alumnos 
        ->get()
        ->each(function (User $user) use ($event) {        
        Notification::send($user, new RecursamientoNotification2($event->recursamientoAdmin));
    });

 
    }*/
        // Accediendo al tutor asociado al recursamiento
        $tutor = $event->recursamientoAdmin->recursamiento->profesor->user;

        // Verificando si el tutor existe y tiene el rol correcto
        if ($tutor && in_array($tutor->role, ['Admin', 'Tutor'])) {
            // Enviando la notificación solo al tutor
            Notification::send($tutor, new RecursamientoNotification2($event->recursamientoAdmin));
        }
        // Enviando la notificación al administrador
        $admin = User::where('role', 'Admin')->first();
        if ($admin) {
            Notification::send($admin, new RecursamientoNotification2($event->recursamientoAdmin));
        }
    }
}
