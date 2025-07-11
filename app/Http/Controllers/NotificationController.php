<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Afficher les notifications de l'utilisateur connecté
     */
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(20);
        $unreadCount = $user->unreadNotifications->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Récupérer les notifications non lues (API)
     */
    public function getUnread()
    {
        $notifications = $this->notificationService->getUnreadNotifications(auth()->id());

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => $notifications->count()
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead($id)
    {
        $result = $this->notificationService->markAsRead($id, auth()->id());

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Notification marquée comme lue' : 'Erreur lors de la mise à jour'
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        $result = $this->notificationService->markAllAsRead(auth()->id());

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Toutes les notifications ont été marquées comme lues' : 'Erreur'
        ]);
    }

    /**
     * Tester l'envoi d'une notification
     */
    public function test(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $this->notificationService->trigger($request->event, $request->data ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Notification de test envoyée'
        ]);
    }
}
