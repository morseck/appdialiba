<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class DatabaseNotification extends Notification implements ShouldQueue
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
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => $this->notificationType->name,
            'title' => $this->notificationType->display_name,
            'message' => $this->message,
            'data' => $this->data,
            'created_at' => now()
        ];
    }
}
