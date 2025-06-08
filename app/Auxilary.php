<?php

use App\Dieuw;
use App\Daara;
use App\Talibe;
use App\Medecin;
use App\Tarbiya;
use App\TransactionLog;

if(!function_exists('app_date_reverse'))
{
	function app_date_reverse($date,$sep,$glue)
	{
		return implode($glue, array_reverse(explode($sep, $date))) ;
	}
}

if( !function_exists('nb_daaras'))
{
	function nb_daaras()
	{
		return Daara::all()->count();
	}
}

if(!function_exists('nb_talibes'))
{
	function nb_talibes()
	{
		return (int) Talibe::all()->count();
	}
}

if(!function_exists('nb_dieuws'))
{
	function nb_dieuws()
	{
		return (int) Dieuw::all()->count();
	}
}

if(!function_exists('nb_medecins'))
{
    function nb_medecins()
    {
        return (int) Medecin::all()->count();
    }
}

if(!function_exists('nb_tarbiyas'))
{
    function nb_tarbiyas()
    {
        return (int) Tarbiya::all()->count();
    }
}

if(!function_exists('niveau_mapper'))
{
	function niveau_mapper()
	{
		$levels = [];
	}
}

if(!function_exists('app_real_filename'))
{
	 function app_real_filename($str)
	{

	    return explode('/', $str)[1];
	}
}

if(!function_exists('fullName'))
{
    function fullName($prenom, $nom)
    {
        return ucfirst(strtolower($prenom)).' '.strtoupper($nom);
    }
}

if(!function_exists('getMedecin'))
{
    function getMedecin($id)
    {
        return Medecin::find($id);
    }
}

if (!function_exists('log_transaction')) {
    /**
     * Logger une transaction manuellement
     */
    function log_transaction($model, $action, $oldValues = null, $newValues = null, $description = null, $context = null)
    {
        return TransactionLog::logTransaction($model, $action, $oldValues, $newValues, $description, $context);
    }
}

if (!function_exists('get_recent_logs')) {
    /**
     * Récupérer les logs récents
     */
    function get_recent_logs($days = 7, $limit = 50)
    {
        return TransactionLog::recent($days)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

if (!function_exists('get_model_logs')) {
    /**
     * Récupérer les logs pour un modèle spécifique
     */
    function get_model_logs($modelType, $modelId = null, $limit = 20)
    {
        $query = TransactionLog::forModel($modelType);

        if ($modelId) {
            $query->where('model_id', $modelId);
        }

        return $query->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

if (!function_exists('get_user_activity')) {
    /**
     * Récupérer l'activité d'un utilisateur
     */
    function get_user_activity($userId, $days = 30, $limit = 50)
    {
        return TransactionLog::byUser($userId)
            ->recent($days)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

if (!function_exists('nb_transactions_today')) {
    /**
     * Compter les transactions d'aujourd'hui
     */
    function nb_transactions_today()
    {
        return TransactionLog::whereDate('created_at', today())->count();
    }
}

if (!function_exists('nb_transactions_by_action')) {
    /**
     * Compter les transactions par action
     */
    function nb_transactions_by_action($action, $days = 30)
    {
        return TransactionLog::byAction($action)
            ->recent($days)
            ->count();
    }
}

if (!function_exists('get_transaction_stats')) {
    /**
     * Récupérer les statistiques des transactions
     */
    function get_transaction_stats($days = 30)
    {
        $stats = TransactionLog::recent($days)
            ->selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->pluck('count', 'action')
            ->toArray();

        return [
            'creates' => $stats['create'] ?? 0,
            'updates' => $stats['update'] ?? 0,
            'deletes' => $stats['delete'] ?? 0,
            'total' => array_sum($stats)
        ];
    }
}

if (!function_exists('get_most_active_users')) {
    /**
     * Récupérer les utilisateurs les plus actifs
     */
    function get_most_active_users($days = 30, $limit = 10)
    {
        return TransactionLog::recent($days)
            ->whereNotNull('user_id')
            ->selectRaw('user_id, user_name, user_email, COUNT(*) as transaction_count')
            ->groupBy('user_id', 'user_name', 'user_email')
            ->orderBy('transaction_count', 'desc')
            ->limit($limit)
            ->get();
    }
}

if (!function_exists('clean_old_logs')) {
    /**
     * Nettoyer les anciens logs (à utiliser dans une commande artisan ou un cron)
     */
    function clean_old_logs($days = 365)
    {
        return TransactionLog::where('created_at', '<', now()->subDays($days))->delete();
    }

}
?>
