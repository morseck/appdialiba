<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dieuw extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable = [
        'prenom', 'nom', 'genre', 'pere', 'mere', 'datenaissance', 'lieunaissance', 'adresse', 'region',
        'tuteur', 'phone1', 'phone2', 'arrivee', 'depart', 'deces', 'commentaire', 'avatar', 'daara_id', 'user_id'
    ];

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function daara()
    {
        return $this->belongsTo('App\Daara');
    }

    public function talibes()
    {
        return $this->hasMany('App\Talibe');
    }

    public function fullname()
    {
        return ucfirst($this->prenom) . ' ' . ucfirst($this->nom);
    }

    public function age()
    {
        $age = null;
        if ($this->datenaissance != null) {
            $date_naissance = app_date_reverse($this->datenaissance, '-', '-');
            $age = new \DateTime('' . $date_naissance . '');
            $age = intval($age->diff(new \DateTime())->format('%Y'));
        }
        return $age;
    }

    public function getTitleStart($withPreposition = null)
    {
        return $withPreposition ? ($this->genre ? 'du serigne' : 'de la sokhna')
            : ($this->genre ? 'serigne' : 'sokhna');
    }

    public function getTitleEnd($withPreposition = null)
    {
        return $withPreposition ? ($this->genre ? 'au serigne' : 'à la sokhna')
            : ($this->genre ? 'serigne' : 'sokhna');
    }

    /**
     * Créer automatiquement un compte User pour ce dieuw
     */
    public function createUserAccount($password = null)
    {
        if ($this->user_id) {
            return $this->user;
        }

        // Générer un email si il n'existe pas
        $email = $this->generateEmail();

        $user = User::create([
            'name' => $this->fullname(),
            'email' => $email,
            'password' => bcrypt($password ?: 'dieuw123'),
            'is_admin' => false
        ]);

        // Assigner le rôle de dieuw si il existe
        if ($role = Role::where('name', 'dieuw')->first()) {
            $user->assignRole($role);
        }

        $this->update(['user_id' => $user->id]);

        return $user;
    }

    /**
     * Générer un email unique pour le dieuw
     */
    private function generateEmail()
    {
        $base = strtolower(str_slug($this->prenom . '.' . $this->nom, '.'));
        $email = $base . '@dieuw.local';

        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = $base . $counter . '@dieuw.local';
            $counter++;
        }

        return $email;
    }

    /**
     * Vérifier si le dieuw a un compte utilisateur
     */
    public function hasUserAccount()
    {
        return !is_null($this->user_id) && $this->user()->exists();
    }

    /**
     * Scope pour les dieuws avec compte utilisateur
     */
    public function scopeWithUserAccount($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope pour les dieuws sans compte utilisateur
     */
    public function scopeWithoutUserAccount($query)
    {
        return $query->whereNull('user_id');
    }
}
