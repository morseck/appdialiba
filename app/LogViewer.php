<?php

namespace App;

use Carbon\Carbon;

class LogViewer
{
    protected $logPath;

    public function __construct()
    {
        $this->logPath = storage_path('logs');
    }

    /**
     * Récupère tous les fichiers de logs
     */
    public function getLogFiles()
    {
        $files = [];

        if (!is_dir($this->logPath)) {
            return $files;
        }

        $logFiles = glob($this->logPath . '/laravel-*.log');

        foreach ($logFiles as $file) {
            $filename = basename($file);
            $files[] = [
                'name' => $filename,
                'path' => $file,
                'size' => $this->formatBytes(filesize($file)),
                'modified' => Carbon::createFromTimestamp(filemtime($file))->format('d/m/Y H:i:s'),
                'modified_diff' => Carbon::createFromTimestamp(filemtime($file))->diffForHumans(),
            ];
        }

        // Trier par date de modification (plus récent en premier)
        usort($files, function($a, $b) {
            return filemtime($b['path']) - filemtime($a['path']);
        });

        return $files;
    }

    /**
     * Récupère le chemin complet d'un fichier de log
     */
    public function getLogPath($filename)
    {
        return $this->logPath . '/' . $filename;
    }

    /**
     * Parse un fichier de log et retourne un tableau structuré
     */
    public function parseLogs($logPath)
    {
        $logs = [];

        if (!file_exists($logPath)) {
            return $logs;
        }

        $content = file_get_contents($logPath);
        $lines = explode("\n", $content);

        $currentLog = null;

        foreach ($lines as $line) {
            if (empty(trim($line))) {
                continue;
            }

            // Pattern pour détecter une nouvelle entrée de log
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)/', $line, $matches)) {
                // Sauvegarder le log précédent s'il existe
                if ($currentLog !== null) {
                    $logs[] = $currentLog;
                }

                // Créer un nouveau log
                $currentLog = [
                    'date' => $matches[1],
                    'env' => $matches[2],
                    'level' => $matches[3],
                    'message' => $matches[4],
                    'context' => '',
                    'stack_trace' => ''
                ];
            } else {
                // Ajouter la ligne au contexte ou à la stack trace du log actuel
                if ($currentLog !== null) {
                    if (strpos($line, '#') === 0 || strpos($line, ' at ') !== false) {
                        $currentLog['stack_trace'] .= $line . "\n";
                    } else {
                        $currentLog['context'] .= $line . "\n";
                    }
                }
            }
        }

        // Ajouter le dernier log
        if ($currentLog !== null) {
            $logs[] = $currentLog;
        }

        return array_reverse($logs); // Plus récent en premier
    }

    /**
     * Retourne les niveaux de log disponibles
     */
    public function getLogLevels()
    {
        return [
            'emergency' => 'Emergency',
            'alert' => 'Alert',
            'critical' => 'Critical',
            'error' => 'Error',
            'warning' => 'Warning',
            'notice' => 'Notice',
            'info' => 'Info',
            'debug' => 'Debug'
        ];
    }

    /**
     * Retourne la couleur CSS pour un niveau de log
     */
    public function getLevelColor($level)
    {
        $colors = [
            'emergency' => '#dc3545',
            'alert' => '#fd7e14',
            'critical' => '#dc3545',
            'error' => '#dc3545',
            'warning' => '#ffc107',
            'notice' => '#17a2b8',
            'info' => '#28a745',
            'debug' => '#6c757d'
        ];

        return isset($colors[strtolower($level)]) ? $colors[strtolower($level)] : '#6c757d';
    }

    /**
     * Formate la taille d'un fichier
     */
    private function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = ['B', 'KB', 'MB', 'GB', 'TB'];

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
