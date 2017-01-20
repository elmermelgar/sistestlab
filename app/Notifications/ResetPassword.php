<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * El token para el reset de la contraseña.
     *
     * @var string
     */
    public $token;

    /**
     * Crea una instancia de notificacion.
     *
     * @param  string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Obtener los canales de envío de la notificación.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Obtiene la representacion de correo electrónico para la notificación.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Cambio de contraseña')
            ->greeting('Buen día')
            ->line('Ha recibido este correo para que pueda cambiar la contraseña de su cuenta.')
            ->action('Cambiar Contraseña', url('password/reset', $this->token));
    }

}
