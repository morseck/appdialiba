<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogViewer;
use Carbon\Carbon;

class LogController extends Controller
{
    protected $logViewer;

    public function __construct()
    {
        $this->logViewer = new LogViewer();
    }

    /**
     * Affiche la liste des fichiers de logs
     */
    public function index()
    {
        $logFiles = $this->logViewer->getLogFiles();
        return view('logs.index', compact('logFiles'));
    }

    /**
     * Affiche le contenu d'un fichier de log spécifique
     */
    public function show(Request $request, $filename)
    {
        $logPath = $this->logViewer->getLogPath($filename);

        if (!file_exists($logPath)) {
            return redirect()->route('logs.index')->with('error', 'Fichier de log introuvable');
        }

        $logs = $this->logViewer->parseLogs($logPath);

        // Filtrage par niveau si spécifié
        $level = $request->get('level');
        if ($level && $level !== 'all') {
            $logs = array_filter($logs, function($log) use ($level) {
                return strtolower($log['level']) === strtolower($level);
            });
        }

        // Recherche dans les logs
        $search = $request->get('search');
        if ($search) {
            $logs = array_filter($logs, function($log) use ($search) {
                return stripos($log['message'], $search) !== false ||
                    stripos($log['context'], $search) !== false;
            });
        }

        // Pagination manuelle
        $perPage = 50;
        $page = $request->get('page', 1);
        $offset = ($page - 1) * $perPage;
        $totalLogs = count($logs);
        $logs = array_slice($logs, $offset, $perPage);

        $pagination = [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $totalLogs,
            'last_page' => ceil($totalLogs / $perPage),
            'has_more' => $totalLogs > ($offset + $perPage)
        ];

        return view('logs.show', compact('logs', 'filename', 'pagination', 'level', 'search'));
    }

    /**
     * Supprime un fichier de log
     */
    public function delete($filename)
    {
        $logPath = $this->logViewer->getLogPath($filename);

        if (file_exists($logPath)) {
            unlink($logPath);
            return redirect()->route('logs.index')->with('success', 'Fichier de log supprimé avec succès');
        }

        return redirect()->route('logs.index')->with('error', 'Fichier de log introuvable');
    }

    /**
     * Télécharge un fichier de log
     */
    public function download($filename)
    {
        $logPath = $this->logViewer->getLogPath($filename);

        if (file_exists($logPath)) {
            return response()->download($logPath);
        }

        return redirect()->route('logs.index')->with('error', 'Fichier de log introuvable');
    }

    /**
     * Vide tous les logs
     */
    public function clear()
    {
        $logFiles = $this->logViewer->getLogFiles();

        foreach ($logFiles as $file) {
            $logPath = $this->logViewer->getLogPath($file['name']);
            if (file_exists($logPath)) {
                file_put_contents($logPath, '');
            }
        }

        return redirect()->route('logs.index')->with('success', 'Tous les logs ont été vidés');
    }
}
