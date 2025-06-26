<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class NotificationLog extends Model
{
    protected $fillable = [
        'notification_type_id',
        'channel',
        'recipient_id',
        'message',
        'status',
        'error_message',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function markAsSent()
    {
        $this->update(['status' => 'sent']);
    }

    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage
        ]);
    }
}
