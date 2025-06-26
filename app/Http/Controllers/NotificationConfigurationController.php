<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\NotificationType;
use App\NotificationConfiguration;

class NotificationConfigurationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Afficher les types de notifications
     */
    public function index()
    {
        $this->authorize('manage-notifications');

        $notificationTypes = NotificationType::with('configurations')->get();
        return view('admin.notifications.types.index', compact('notificationTypes'));
    }

    /**
     * Afficher les configurations
     */
    public function configurations()
    {
        $this->authorize('manage-notifications');

        $configurations = NotificationConfiguration::with(['notificationType', 'user', 'daara'])
            ->paginate(20);

        return view('admin.notifications.configurations.index', compact('configurations'));
    }

    /**
     * Créer une nouvelle configuration
     */
    public function store(Request $request)
    {
        $this->authorize('manage-notifications');

        $request->validate([
            'notification_type_id' => 'required|exists:notification_types,id',
            'channels' => 'required|array',
            'channels.*' => 'in:database,mail,sms',
            'recipients' => 'array',
            'recipients.*' => 'exists:users,id',
            'daara_id' => 'nullable|exists:daaras,id',
            'conditions' => 'nullable|array'
        ]);

        $configuration = $this->notificationService->createConfiguration($request->all());

        return response()->json([
            'success' => true,
            'data' => $configuration,
            'message' => 'Configuration créée avec succès'
        ]);
    }

    /**
     * Mettre à jour une configuration
     */
    public function update(Request $request, $id)
    {
        $this->authorize('manage-notifications');

        $configuration = NotificationConfiguration::findOrFail($id);

        $request->validate([
            'channels' => 'required|array',
            'channels.*' => 'in:database,mail,sms',
            'recipients' => 'array',
            'recipients.*' => 'exists:users,id',
            'conditions' => 'nullable|array'
        ]);

        $configuration->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $configuration,
            'message' => 'Configuration mise à jour'
        ]);
    }

    /**
     * Supprimer une configuration
     */
    public function destroy($id)
    {
        $this->authorize('manage-notifications');

        $configuration = NotificationConfiguration::findOrFail($id);
        $configuration->delete();

        return response()->json([
            'success' => true,
            'message' => 'Configuration supprimée'
        ]);
    }

    /**
     * Activer/Désactiver une configuration
     */
    public function toggle($id)
    {
        $this->authorize('manage-notifications');

        $configuration = NotificationConfiguration::findOrFail($id);
        $configuration->update(['is_active' => !$configuration->is_active]);

        return response()->json([
            'success' => true,
            'data' => $configuration,
            'message' => 'Statut mis à jour'
        ]);
    }
}
