<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ColaboradorBoasVindas extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->subject('Bem-vindo à Empresa!')
            ->greeting("Olá {$notifiable->nome}!")
            ->line('Seja bem-vindo à nossa empresa!')
            ->line('Estamos muito felizes em tê-lo conosco.')
            ->action('Acessar o Sistema', url('/'))
            ->line('Obrigado por se juntar a nós!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'colaborador_id' => $notifiable->id,
            'nome' => $notifiable->nome,
        ];
    }
}