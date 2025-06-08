<?php

namespace App\Traits;

use App\TransactionLog;

trait Loggable
{
    /**
     * Champs à exclure du logging
     */
    protected $excludeFromLog = [
        'created_at',
        'updated_at',
        'deleted_at',
        'remember_token',
        'password'
    ];

    /**
     * Boot du trait
     */
    public static function bootLoggable()
    {
        // Log lors de la création
        static::created(function ($model) {
            if ($model->shouldLog('create')) {
                $model->logModelTransaction('create', null, $model->getLoggableAttributes());
            }
        });

        // Log lors de la mise à jour
        static::updated(function ($model) {
            if ($model->shouldLog('update')) {
                $model->logModelTransaction('update', $model->getOriginal(), $model->getAttributes());
            }
        });

        // Log lors de la suppression
        static::deleted(function ($model) {
            if ($model->shouldLog('delete')) {
                $model->logModelTransaction('delete', $model->getOriginal(), null);
            }
        });
    }

    /**
     * Vérifier si l'action doit être loggée
     */
    protected function shouldLog($action)
    {
        // Vous pouvez personnaliser cette logique selon vos besoins
        if (property_exists($this, 'disableLogging') && $this->disableLogging) {
            return false;
        }

        if (property_exists($this, 'logOnly') && is_array($this->logOnly)) {
            return in_array($action, $this->logOnly);
        }

        if (property_exists($this, 'logExcept') && is_array($this->logExcept)) {
            return !in_array($action, $this->logExcept);
        }

        return true;
    }

    /**
     * Récupérer les attributs à logger
     */
    protected function getLoggableAttributes($attributes = null)
    {
        if ($attributes === null) {
            $attributes = $this->getAttributes();
        }

        $excludeFields = array_merge(
            $this->excludeFromLog,
            property_exists($this, 'excludeFromLog') ? $this->excludeFromLog : []
        );

        return array_diff_key($attributes, array_flip($excludeFields));
    }

    /**
     * Logger une transaction pour ce modèle
     */
    public function logModelTransaction($action, $oldValues = null, $newValues = null, $description = null, $context = null)
    {
        return TransactionLog::logTransaction(
            $this,
            $action,
            $oldValues ? $this->getLoggableAttributes($oldValues) : null,
            $newValues ? $this->getLoggableAttributes($newValues) : null,
            $description,
            $context
        );
    }

    /**
     * Récupérer les logs de transaction pour ce modèle
     */
    public function transactionLogs()
    {
        return $this->morphMany('App\TransactionLog', 'model', 'model_type', 'model_id');
    }

    /**
     * Récupérer les logs récents
     */
    public function recentLogs($days = 30)
    {
        return $this->transactionLogs()->recent($days)->orderBy('created_at', 'desc');
    }

    /**
     * Désactiver temporairement le logging
     */
    public function withoutLogging(callable $callback)
    {
        $this->disableLogging = true;

        try {
            return $callback($this);
        } finally {
            $this->disableLogging = false;
        }
    }

    /**
     * Logger une action personnalisée
     */
    public function logCustomAction($action, $description = null, $context = null)
    {
        return $this->logModelTransaction($action, null, null, $description, $context);
    }
}
