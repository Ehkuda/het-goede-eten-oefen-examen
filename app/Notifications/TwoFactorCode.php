<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TwoFactorCode extends Notification
{
    use Queueable;

    public $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Je inlogcode voor Het Goede Eten')
            ->greeting('Hallo ' . $notifiable->name . ',')
            ->line('Gebruik onderstaande code om in te loggen:')
            ->line('**' . $this->code . '**')
            ->line('Deze code verloopt na 10 minuten.')
            ->line('Als je dit niet verwacht had, neem dan contact op.')
            ->salutation('Groet, Het Goede Eten');
    }
}