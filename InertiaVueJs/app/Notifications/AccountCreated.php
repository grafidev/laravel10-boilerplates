<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
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
        return (new MailMessage())
            ->theme('cardoil')
            ->greeting('Bonjour '.$notifiable->name)
            ->subject('Création de votre compte sur '.url('/'))
            ->line("Votre compte vient d'être créé")
            ->line('Veuillez cliquer sur le bouton ci dessous pour définir un nouveau mot de passe')
            ->action('Modifier mon mot de passe', url($notifiable->getNewPasswordUrl()))
            ->line(sprintf('Ce lien expirera le %s', $notifiable->new_password_token_expiration_date?->format('d/m/Y à H:i')))
            ->salutation('Merci, Cordialement');
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
