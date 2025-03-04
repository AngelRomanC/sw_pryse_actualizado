<?php

namespace App\Notifications;

use App\Models\ListaRecursamiento;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecursamientoNotification2 extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $recursamientoAdmin;


    public function __construct(ListaRecursamiento $recursamientoAdmin )
    {
        //
        $this->recursamientoAdmin = $recursamientoAdmin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['broadcast','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $nombreCompleto = $this->recursamientoAdmin->user->name . ' ' . $this->recursamientoAdmin->user->apellido_paterno. ' ' . $this->recursamientoAdmin->user->apellido_materno;
        return [
            
              
            'materia2' => $this->recursamientoAdmin->recursamiento->materia->nombre,
            //'alumno' => 'Usuario: ' . $this->recursamientoAdmin->user->name,
            'alumno' => 'Alumno: ' . $nombreCompleto,                  
                        
            'message2' => 'Se ha agregado un nuevo alumno al recursamiento', 
            'time' =>Carbon::now()-> diffForHumans(),
            

        ];
    }
}
