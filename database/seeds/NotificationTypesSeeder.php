<?php

// Seeder NotificationTypesSeeder.php
use Illuminate\Database\Seeder;
use App\NotificationType;

class NotificationTypesSeeder extends Seeder
{
    public function run()
    {
        $notificationTypes = [
            [
                'name' => 'talibe.created',
                'display_name' => 'Nouveau Talibé',
                'description' => 'Notification envoyée lors de l\'ajout d\'un nouveau talibé',
                'message_template' => 'Un nouveau talibé {{talibe_nom}} ({{talibe_age}} ans) a été ajouté au daara {{daara_nom}} par {{user_nom}} le {{date}}.',
                'event_trigger' => 'talibe.created',
                'channels' => ['database', 'mail'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'admin'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ],
            [
                'name' => 'talibe.updated',
                'display_name' => 'Modification Talibé',
                'description' => 'Notification envoyée lors de la modification d\'un talibé',
                'message_template' => 'Les informations du talibé {{talibe_nom}} ont été modifiées ({{changes}}) par {{user_nom}} le {{date}}.',
                'event_trigger' => 'talibe.updated',
                'channels' => ['database'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'admin']
                ],
                'is_active' => true
            ],
            [
                'name' => 'talibe.daara_changed',
                'display_name' => 'Changement de Daara',
                'description' => 'Notification envoyée lors du transfert d\'un talibé vers un autre daara',
                'message_template' => 'Le talibé {{talibe_nom}} a été transféré du daara {{ancien_daara}} vers {{nouveau_daara}} par {{user_nom}} le {{date}}.',
                'event_trigger' => 'talibe.daara_changed',
                'channels' => ['database', 'mail', 'sms'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'admin'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ],
            [
                'name' => 'talibe.hizib_changed',
                'display_name' => 'Changement de Hizib',
                'description' => 'Notification envoyée lors du changement de niveau d\'un talibé',
                'message_template' => 'Le talibé {{talibe_nom}} est passé du hizib {{ancien_hizib}} au hizib {{nouveau_hizib}} dans le daara {{daara_nom}} le {{date}}.',
                'event_trigger' => 'talibe.hizib_changed',
                'channels' => ['database'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'enseignant'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ],
            [
                'name' => 'dieuw.created',
                'display_name' => 'Nouveau Dieuw',
                'description' => 'Notification envoyée lors de l\'ajout d\'un nouveau dieuw/enseignant',
                'message_template' => 'Un nouveau dieuw {{dieuw_nom}} a été ajouté au daara {{daara_nom}} par {{user_nom}} le {{date}}.',
                'event_trigger' => 'dieuw.created',
                'channels' => ['database', 'mail'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'admin'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ],
            [
                'name' => 'consultation.created',
                'display_name' => 'Nouvelle Consultation',
                'description' => 'Notification envoyée lors d\'une consultation médicale',
                'message_template' => 'Une consultation médicale a été enregistrée pour le talibé {{talibe_nom}} le {{date}}. Diagnostic: {{diagnostic}}.',
                'event_trigger' => 'consultation.created',
                'channels' => ['database', 'sms'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'medecin'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ],
            [
                'name' => 'talibe.absent',
                'display_name' => 'Absence Talibé',
                'description' => 'Notification d\'absence prolongée d\'un talibé',
                'message_template' => 'Le talibé {{talibe_nom}} est absent depuis {{nombre_jours}} jours du daara {{daara_nom}}. Dernière présence: {{derniere_presence}}.',
                'event_trigger' => 'talibe.absent',
                'channels' => ['database', 'sms'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'responsable_daara'],
                    ['type' => 'role', 'value' => 'enseignant']
                ],
                'is_active' => true
            ],
            [
                'name' => 'rappel.medical',
                'display_name' => 'Rappel Médical',
                'description' => 'Rappel pour les visites médicales périodiques',
                'message_template' => 'Rappel: Le talibé {{talibe_nom}} doit effectuer sa visite médicale. Dernière consultation: {{derniere_consultation}}.',
                'event_trigger' => 'rappel.medical',
                'channels' => ['database', 'mail'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'medecin'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ],
            [
                'name' => 'daara.rapport',
                'display_name' => 'Rapport Daara',
                'description' => 'Rapport périodique des activités du daara',
                'message_template' => 'Rapport mensuel du daara {{daara_nom}}: {{nombre_talibes}} talibés, {{nombre_consultations}} consultations, {{nombre_evenements}} événements.',
                'event_trigger' => 'daara.rapport',
                'channels' => ['mail'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'admin'],
                    ['type' => 'role', 'value' => 'directeur']
                ],
                'is_active' => true
            ],
            [
                'name' => 'urgence.medicale',
                'display_name' => 'Urgence Médicale',
                'description' => 'Alerte pour les urgences médicales',
                'message_template' => 'URGENCE: Le talibé {{talibe_nom}} du daara {{daara_nom}} nécessite une attention médicale immédiate. Motif: {{motif}}.',
                'event_trigger' => 'urgence.medicale',
                'channels' => ['database', 'mail', 'sms'],
                'default_recipients' => [
                    ['type' => 'role', 'value' => 'medecin'],
                    ['type' => 'role', 'value' => 'admin'],
                    ['type' => 'role', 'value' => 'responsable_daara']
                ],
                'is_active' => true
            ]
        ];

        foreach ($notificationTypes as $type) {
            NotificationType::create($type);
        }
    }
}

// Seeder DefaultNotificationConfigurationsSeeder.php
class DefaultNotificationConfigurationsSeeder extends Seeder
{
    public function run()
    {
        // Exemple de configurations par défaut
        $configurations = [
            [
                'notification_type_id' => 1, // talibe.created
                'user_id' => null, // Configuration globale
                'daara_id' => null,
                'channels' => ['database', 'mail'],
                'recipients' => null, // Utilise les destinataires par défaut
                'custom_message' => null,
                'conditions' => null,
                'is_active' => true
            ],
            [
                'notification_type_id' => 3, // talibe.daara_changed
                'user_id' => null,
                'daara_id' => null,
                'channels' => ['database', 'mail', 'sms'],
                'recipients' => null,
                'custom_message' => 'TRANSFERT: {{talibe_nom}} transféré de {{ancien_daara}} vers {{nouveau_daara}}. Contact: {{user_nom}}',
                'conditions' => null,
                'is_active' => true
            ],
            [
                'notification_type_id' => 10, // urgence.medicale
                'user_id' => null,
                'daara_id' => null,
                'channels' => ['sms', 'mail'],
                'recipients' => null,
                'custom_message' => '🚨 URGENCE MÉDICALE 🚨\n{{talibe_nom}} - {{daara_nom}}\nMotif: {{motif}}\nAction immédiate requise!',
                'conditions' => null,
                'is_active' => true
            ]
        ];

        foreach ($configurations as $config) {
            \App\NotificationConfiguration::create($config);
        }
    }
}
