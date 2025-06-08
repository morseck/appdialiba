<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'action',
        'user_id',
        'user_name',
        'user_email',
        'old_values',
        'new_values',
        'changes',
        'ip_address',
        'user_agent',
        'description',
        'context'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'changes' => 'array',
    ];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Récupérer le modèle concerné (relation polymorphique)
     */
    public function model()
    {
        return $this->morphTo('model', 'model_type', 'model_id');
    }

    /**
     * Scope pour filtrer par type de modèle
     */
    public function scopeForModel($query, $modelType)
    {
        return $query->where('model_type', $modelType);
    }

    /**
     * Scope pour filtrer par action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope pour filtrer par utilisateur
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope pour récupérer les logs récents
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Méthode statique pour créer un log
     */
    public static function logTransaction($model, $action, $oldValues = null, $newValues = null, $description = null, $context = null)
    {
        $user = auth()->user();
        $request = request();

        // Calculer les changements pour les updates
        $changes = null;
        if ($action === 'update' && $oldValues && $newValues) {
            $changes = [];
            foreach ($newValues as $key => $newValue) {
                $oldValue = isset($oldValues[$key]) ? $oldValues[$key] : null;
                if ($oldValue != $newValue) {
                    $changes[$key] = [
                        'old' => $oldValue,
                        'new' => $newValue
                    ];
                }
            }
        }

        return self::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : null,
            'user_email' => $user ? $user->email : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'changes' => $changes,
            'ip_address' => $request ? $request->ip() : null,
            'user_agent' => $request ? $request->userAgent() : null,
            'description' => $description,
            'context' => $context
        ]);
    }

    /**
     * Formater la description de l'action
     */
    public function getFormattedDescription()
    {
        $modelName = class_basename($this->model_type);
        $userName = $this->user_name ?: 'Système';

        switch ($this->action) {
            case 'create':
                return "{$userName} a créé un(e) {$modelName} (ID: {$this->model_id})";
            case 'update':
                return "{$userName} a modifié un(e) {$modelName} (ID: {$this->model_id})";
            case 'delete':
                return "{$userName} a supprimé un(e) {$modelName} (ID: {$this->model_id})";
            default:
                return "{$userName} a effectué l'action '{$this->action}' sur un(e) {$modelName} (ID: {$this->model_id})";
        }
    }

    /**
     * Récupérer les changements formatés
     */
    public function getFormattedChanges()
    {
        if (!$this->changes) {
            return null;
        }

        $formatted = [];
        foreach ($this->changes as $field => $change) {
            $formatted[] = [
                'field' => $field,
                'old' => $change['old'],
                'new' => $change['new']
            ];
        }

        return $formatted;
    }
}
