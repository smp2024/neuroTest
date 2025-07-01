<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FormLinkNotification extends Notification
{
    use Queueable;
    public $link;
    public $patient;
    /**
     * Create a new notification instance.
     */
    public function __construct($link, $patient)
    {
        $this->link = $link;
        $this->patient = $patient;
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
        return (new MailMessage)
            ->subject('Formulario para completar - ' . $this->patient->name)
            ->greeting('Hola, ' . $notifiable->name_companion)
            ->line('Por favor complete el siguiente formulario relacionado con el paciente ' . $this->patient->name)
            ->action('Ir al formulario', url('/formulario/' . $this->link->token))
            ->line('Este enlace caduca en 7 días.');
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
