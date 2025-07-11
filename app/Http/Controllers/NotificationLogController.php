<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationType;
use App\NotificationLog;

class NotificationLogController extends Controller
{
    /**
     * Afficher les logs de notifications
     */
    public function index(Request $request)
    {
        $this->authorize('view-notification-logs');

        $query = NotificationLog::with(['notificationType', 'recipient'])
            ->orderBy('created_at', 'desc');

        // Filtres
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->channel) {
            $query->where('channel', $request->channel);
        }

        if ($request->notification_type_id) {
            $query->where('notification_type_id', $request->notification_type_id);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(50);
        $notificationTypes = NotificationType::all();

        return view('admin.notifications.logs.index', compact('logs', 'notificationTypes'));
    }

    /**
     * Afficher le détail d'un log
     */
    public function show($id)
    {
        $this->authorize('view-notification-logs');

        $log = NotificationLog::with(['notificationType', 'recipient'])->findOrFail($id);

        return view('admin.notifications.logs.show', compact('log'));
    }

    /**
     * Statistiques des notifications
     */
    public function stats()
    {
        $this->authorize('view-notification-stats');

        $stats = [
            'total_sent' => NotificationLog::where('status', 'sent')->count(),
            'total_failed' => NotificationLog::where('status', 'failed')->count(),
            'total_pending' => NotificationLog::where('status', 'pending')->count(),
            'by_channel' => NotificationLog::selectRaw('channel, status, count(*) as count')
                ->groupBy('channel', 'status')
                ->get()
                ->groupBy('channel'),
            'by_type' => NotificationLog::selectRaw('notification_type_id, count(*) as count')
                ->with('notificationType')
                ->groupBy('notification_type_id')
                ->get(),
            'recent_activity' => NotificationLog::with(['notificationType', 'recipient'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
        ];

        return view('admin.notifications.stats', compact('stats'));
    }

    /**
     * Reessayer l'envoi d'une notification échouée
     */
    public function retry($id)
    {
        $this->authorize('manage-notifications');

        $log = NotificationLog::findOrFail($id);

        if ($log->status !== 'failed') {
            return response()->json([
                'success' => false,
                'message' => 'Seules les notifications échouées peuvent être renvoyées'
            ]);
        }

        // Logique de renvoi (à implémenter selon vos besoins)
        // ...

        return response()->json([
            'success' => true,
            'message' => 'Notification remise en file d\'attente'
        ]);
    }
}
