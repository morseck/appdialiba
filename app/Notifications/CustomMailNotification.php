<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomMailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $notificationType;
    protected $data;
    protected $message;

    public function __construct($notificationType, $data, $message)
    {
        $this->notificationType = $notificationType;
        $this->data = $data;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->notificationType->display_name)
            ->line($this->message)
            ->action('Voir dans l\'application', url('/'))
            ->line('Merci d\'utiliser notre application!');
    }
}
