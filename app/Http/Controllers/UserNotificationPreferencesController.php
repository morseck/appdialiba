<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationType;
use App\NotificationConfiguration;

class UserNotificationPreferencesController extends Controller
{
    /**
     * Afficher les préférences de l'utilisateur
     */
    public function index()
    {
        $user = auth()->user();
        $notificationTypes = NotificationType::where('is_active', true)->get();

        $userConfigurations = NotificationConfiguration::where('user_id', $user->id)
            ->get()
            ->keyBy('notification_type_id');

        return view('notifications.preferences', compact('notificationTypes', 'userConfigurations'));
    }

    /**
     * Mettre à jour les préférences
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'preferences' => 'required|array',
            'preferences.*.channels' => 'array',
            'preferences.*.channels.*' => 'in:database,mail,sms'
        ]);

        foreach ($request->preferences as $typeId => $preferences) {
            NotificationConfiguration::updateOrCreate(
                [
                    'notification_type_id' => $typeId,
                    'user_id' => $user->id,
                    'daara_id' => null
                ],
                [
                    'channels' => $preferences['channels'] ?? [],
                    'is_active' => isset($preferences['enabled']) && $preferences['enabled']
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Préférences mises à jour'
        ]);
    }
}
