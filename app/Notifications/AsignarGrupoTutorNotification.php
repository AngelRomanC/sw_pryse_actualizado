<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use League\CommonMark\Extension\Embed\Embed;

class AsignarGrupoTutorNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $grupo;

    public function __construct($grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $imagen = url('storage/imagenes/Upemor.jpg');
        
        return (new MailMessage)
                    ->subject('Nuevo Grupo Asignado')
                    ->greeting('¡Hola!')
                    ->line('Profesor: ' . $this->grupo->profesor->user->name) // Aquí accedemos al
                    ->line('Se le ha asignado un nuevo grupo.')
                    ->line('Grado: ' . $this->grupo->grado)
                    ->line('Grupo: ' . $this->grupo->grupo)
                    ->action('Ver Grupo', url('/login' ))
                    ->line('¡Gracias por su dedicación y trabajo!')
                   //->line('<img src="' . $this->embed(public_path() . '/storage/imagenes/Upemor.jpg') . '" alt="Imagen">')
                    ->line('<img src="'.$imagen.'" alt="Nombre de la imagen">')

                    ->salutation('Recursamientos');
                   

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
