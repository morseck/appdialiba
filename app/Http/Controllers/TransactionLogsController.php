<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TransactionLog;
use App\User;

class TransactionLogsController extends Controller
{
    /**
     * Afficher la liste des logs de transaction
     */
    public function index(Request $request)
    {
        $query = TransactionLog::with('user')->orderBy('created_at', 'desc');

        // Filtres
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere('model_id', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20);

        // Données pour les filtres
        $modelTypes = TransactionLog::select('model_type')
            ->distinct()
            ->orderBy('model_type')
            ->pluck('model_type');

        $actions = TransactionLog::select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $users = User::select('id', 'name')
            ->orderBy('name')
            ->get();

        // Statistiques rapides
        $stats = [
            'total_today' => TransactionLog::whereDate('created_at', today())->count(),
            'total_week' => TransactionLog::where('created_at', '>=', now()->subWeek())->count(),
            'total_month' => TransactionLog::where('created_at', '>=', now()->subMonth())->count(),
            'by_action' => TransactionLog::where('created_at', '>=', now()->subMonth())
                ->selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->pluck('count', 'action')
        ];

        return view('transaction_logs.index', compact(
            'logs',
            'modelTypes',
            'actions',
            'users',
            'stats'
        ));
    }

    /**
     * Afficher un log spécifique
     */
    public function show($id)
    {
        $log = TransactionLog::with('user')->findOrFail($id);

        // Essayer de récupérer le modèle associé s'il existe encore
        $relatedModel = null;
        if ($log->model_id && class_exists($log->model_type)) {
            try {
                $relatedModel = $log->model_type::find($log->model_id);
            } catch (\Exception $e) {
                // Le modèle n'existe plus ou erreur
            }
        }

        // Logs précédents et suivants du même modèle
        $previousLog = null;
        $nextLog = null;

        if ($log->model_id) {
            $previousLog = TransactionLog::where('model_type', $log->model_type)
                ->where('model_id', $log->model_id)
                ->where('created_at', '<', $log->created_at)
                ->orderBy('created_at', 'desc')
                ->first();

            $nextLog = TransactionLog::where('model_type', $log->model_type)
                ->where('model_id', $log->model_id)
                ->where('created_at', '>', $log->created_at)
                ->orderBy('created_at', 'asc')
                ->first();
        }

        // Logs du même utilisateur dans la même période (1 heure avant/après)
        $relatedLogs = [];
        if ($log->user_id) {
            $relatedLogs = TransactionLog::where('user_id', $log->user_id)
                ->where('id', '!=', $log->id)
                ->whereBetween('created_at', [
                    $log->created_at->subHour(),
                    $log->created_at->addHour()
                ])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        }

        return view('transaction_logs.show', compact(
            'log',
            'relatedModel',
            'previousLog',
            'nextLog',
            'relatedLogs'
        ));
    }

    /**
     * Exporter les logs en CSV
     */
    public function export(Request $request)
    {
        $query = TransactionLog::with('user')->orderBy('created_at', 'desc');

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->limit(1000)->get(); // Limiter pour éviter les timeouts

        $filename = 'transaction_logs_' . date('Y-m-d_H-i-s') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // En-têtes
        fputcsv($output, [
            'ID',
            'Date/Heure',
            'Action',
            'Modèle',
            'ID Modèle',
            'Utilisateur',
            'Email Utilisateur',
            'IP',
            'Description',
            'Changements'
        ]);

        foreach ($logs as $log) {
            $changes = '';
            if ($log->changes) {
                $changesArray = [];
                foreach ($log->changes as $field => $change) {
                    $changesArray[] = $field . ': ' . $change['old'] . ' → ' . $change['new'];
                }
                $changes = implode('; ', $changesArray);
            }

            fputcsv($output, [
                $log->id,
                $log->created_at->format('d/m/Y H:i:s'),
                $log->action,
                class_basename($log->model_type),
                $log->model_id,
                $log->user_name,
                $log->user_email,
                $log->ip_address,
                $log->description ?: $log->getFormattedDescription(),
                $changes
            ]);
        }

        fclose($output);
        exit;
    }
}
