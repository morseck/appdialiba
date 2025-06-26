<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationConfiguration extends Model
{
    protected $fillable = [
        'notification_type_id',
        'user_id',
        'daara_id',
        'channels',
        'recipients',
        'custom_message',
        'conditions',
        'is_active'
    ];

    protected $casts = [
        'channels' => 'array',
        'recipients' => 'array',
        'conditions' => 'array',
        'is_active' => 'boolean'
    ];

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function daara()
    {
        return $this->belongsTo(Daara::class);
    }

    /**
     * Vérifier si les conditions sont remplies
     */
    public function conditionsMatch($data)
    {
        if (empty($this->conditions)) {
            return true;
        }

        foreach ($this->conditions as $condition) {
            $field = $condition['field'];
            $operator = $condition['operator'];
            $value = $condition['value'];
            $dataValue = data_get($data, $field);

            switch ($operator) {
                case '=':
                    if ($dataValue != $value) return false;
                    break;
                case '!=':
                    if ($dataValue == $value) return false;
                    break;
                case '>':
                    if ($dataValue <= $value) return false;
                    break;
                case '<':
                    if ($dataValue >= $value) return false;
                    break;
                case 'contains':
                    if (strpos($dataValue, $value) === false) return false;
                    break;
                case 'in':
                    if (!in_array($dataValue, $value)) return false;
                    break;
            }
        }

        return true;
    }
}
