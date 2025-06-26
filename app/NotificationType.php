<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class NotificationType extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'message_template',
        'event_trigger',
        'channels',
        'default_recipients',
        'is_active'
    ];

    protected $casts = [
        'channels' => 'array',
        'default_recipients' => 'array',
        'is_active' => 'boolean'
    ];

    public function configurations()
    {
        return $this->hasMany(NotificationConfiguration::class);
    }

    public function logs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    /**
     * Générer le message en remplaçant les variables
     */
    public function generateMessage($data = [], $customTemplate = null)
    {
        $template = $customTemplate ?: $this->message_template;

        foreach ($data as $key => $value) {
            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        return $template;
    }

    /**
     * Vérifier si un canal est activé
     */
    public function hasChannel($channel)
    {
        return in_array($channel, $this->channels);
    }
}
