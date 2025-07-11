<?php

namespace App\Services;

use App\NotificationType;
use App\NotificationConfiguration;
use App\NotificationLog;
use App\User;
use App\Daara;
use App\Notifications\DatabaseNotification;
use App\Notifications\CustomMailNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Déclencher une notification
     */
    public function trigger($eventName, $data = [], $contextDaara = null)
    {
        try {
            // Récupérer les types de notifications pour cet événement
            $notificationTypes = NotificationType::where('event_trigger', $eventName)
                ->where('is_active', true)
                ->get();

            foreach ($notificationTypes as $notificationType) {
                $this->processNotificationType($notificationType, $data, $contextDaara);
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors du déclenchement de notification: ' . $e->getMessage());
        }
    }

    /**
     * Traiter un type de notification spécifique
     */
    protected function processNotificationType($notificationType, $data, $contextDaara = null)
    {
        // Récupérer les configurations pour ce type
        $configurations = $this->getConfigurations($notificationType, $contextDaara);

        if ($configurations->isEmpty()) {
            // Utiliser la configuration par défaut
            $this->sendDefaultNotification($notificationType, $data, $contextDaara);
        } else {
            // Traiter chaque configuration
            foreach ($configurations as $config) {
                if ($config->conditionsMatch($data)) {
                    $this->sendConfiguredNotification($notificationType, $config, $data);
                }
            }
        }
    }

    /**
     * Récupérer les configurations appropriées
     */
    protected function getConfigurations($notificationType, $contextDaara = null)
    {
        $query = NotificationConfiguration::where('notification_type_id', $notificationType->id)
            ->where('is_active', true);

        if ($contextDaara) {
            $query->where(function ($q) use ($contextDaara) {
                $q->where('daara_id', $contextDaara->id)
                    ->orWhereNull('daara_id');
            });
        }

        return $query->get();
    }

    /**
     * Envoyer notification avec configuration par défaut
     */
    protected function sendDefaultNotification($notificationType, $data, $contextDaara = null)
    {
        $recipients = $this->getDefaultRecipients($notificationType, $contextDaara);
        $message = $notificationType->generateMessage($data);

        foreach ($notificationType->channels as $channel) {
            $this->sendToChannel($channel, $recipients, $notificationType, $message, $data);
        }
    }

    /**
     * Envoyer notification configurée
     */
    protected function sendConfiguredNotification($notificationType, $config, $data)
    {
        $recipients = $this->getConfiguredRecipients($config);
        $message = $notificationType->generateMessage($data, $config->custom_message);

        foreach ($config->channels as $channel) {
            $this->sendToChannel($channel, $recipients, $notificationType, $message, $data);
        }
    }

    /**
     * Obtenir les destinataires par défaut
     */
    protected function getDefaultRecipients($notificationType, $contextDaara = null)
    {
        $recipients = collect();

        if (!empty($notificationType->default_recipients)) {
            foreach ($notificationType->default_recipients as $recipient) {
                if (isset($recipient['type']) && $recipient['type'] === 'role') {
                    $users = User::withRole($recipient['value'])->get();
                    $recipients = $recipients->merge($users);
                } elseif (isset($recipient['type']) && $recipient['type'] === 'daara_admin' && $contextDaara) {
                    // Logique pour récupérer les admins du daara
                    $users = User::whereHas('roles', function($q) {
                        $q->where('name', 'admin_daara');
                    })->get();
                    $recipients = $recipients->merge($users);
                }
            }
        }

        return $recipients->unique('id');
    }

    /**
     * Obtenir les destinataires configurés
     */
    protected function getConfiguredRecipients($config)
    {
        $recipients = collect();

        if (!empty($config->recipients)) {
            foreach ($config->recipients as $recipientId) {
                $user = User::find($recipientId);
                if ($user) {
                    $recipients->push($user);
                }
            }
        }

        return $recipients;
    }

    /**
     * Envoyer vers un canal spécifique
     */
    protected function sendToChannel($channel, $recipients, $notificationType, $message, $data)
    {
        foreach ($recipients as $recipient) {
            try {
                $log = NotificationLog::create([
                    'notification_type_id' => $notificationType->id,
                    'channel' => $channel,
                    'recipient_id' => $recipient->id,
                    'message' => $message,
                    'status' => 'pending',
                    'metadata' => $data
                ]);

                switch ($channel) {
                    case 'database':
                        $recipient->notify(new DatabaseNotification($notificationType, $data, $message));
                        $log->markAsSent();
                        break;

                    case 'mail':
                        if ($recipient->email) {
                            $recipient->notify(new CustomMailNotification($notificationType, $data, $message));
                            $log->markAsSent();
                        } else {
                            $log->markAsFailed('Email non disponible');
                        }
                        break;

                    case 'sms':
                        $this->sendSms($recipient, $message, $log);
                        break;

                    default:
                        $log->markAsFailed('Canal non supporté: ' . $channel);
                }

            } catch (\Exception $e) {
                Log::error('Erreur envoi notification: ' . $e->getMessage());
                if (isset($log)) {
                    $log->markAsFailed($e->getMessage());
                }
            }
        }
    }

    /**
     * Envoyer SMS (à adapter selon votre provider SMS)
     */
    protected function sendSms($recipient, $message, $log)
    {
        try {
            // Exemple avec un service SMS fictif
            // Remplacez par votre provider réel (Twilio, Nexmo, etc.)

            $phone = $this->getRecipientPhone($recipient);
            if (!$phone) {
                $log->markAsFailed('Numéro de téléphone non disponible');
                return;
            }

            // Simulation d'envoi SMS
            // $smsService = app('sms.service');
            // $result = $smsService->send($phone, $message);

            // Pour la démonstration, on simule un succès
            $log->markAsSent();

        } catch (\Exception $e) {
            $log->markAsFailed($e->getMessage());
        }
    }

    /**
     * Récupérer le téléphone du destinataire
     */
    protected function getRecipientPhone($recipient)
    {
        // Adapter selon votre structure de données
        return $recipient->phone ?? $recipient->phone1 ?? null;
    }

    /**
     * Créer un type de notification
     */
    public function createNotificationType($data)
    {
        return NotificationType::create($data);
    }

    /**
     * Créer une configuration de notification
     */
    public function createConfiguration($data)
    {
        return NotificationConfiguration::create($data);
    }

    /**
     * Obtenir les notifications non lues d'un utilisateur
     */
    public function getUnreadNotifications($userId)
    {
        $user = User::find($userId);
        return $user ? $user->unreadNotifications : collect();
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($notificationId, $userId)
    {
        $user = User::find($userId);
        if ($user) {
            $notification = $user->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                return true;
            }
        }
        return false;
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->unreadNotifications->markAsRead();
            return true;
        }
        return false;
    }
}
