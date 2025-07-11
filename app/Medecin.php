<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medecin extends Model
{
    use SoftDeletes, Loggable;

    protected $fillable = [
        'prenom', 'nom', 'phone', 'email', 'hopital', 'spec', 'image', 'user_id'
    ];

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasMany('App\Consultation');
    }

    public function fullname()
    {
        return ucfirst(strtolower($this->prenom)) . ' ' . strtoupper($this->nom);
    }

    public function ordonnances()
    {
        return $this->hasMany('App\Ordonnance');
    }

    /**
     * Créer automatiquement un compte User pour ce médecin
     */
    public function createUserAccount($password = null)
    {
        if ($this->user_id) {
            return $this->user;
        }

        $user = User::create([
            'name' => $this->fullname(),
            'email' => $this->email,
            'password' => bcrypt($password ?: 'medecin123'),
            'is_admin' => false
        ]);

        // Assigner le rôle de médecin si il existe
        if ($role = Role::where('name', 'medecin')->first()) {
            $user->assignRole($role);
        }

        $this->update(['user_id' => $user->id]);

        return $user;
    }

    /**
     * Vérifier si le médecin a un compte utilisateur
     */
    public function hasUserAccount()
    {
        return !is_null($this->user_id) && $this->user()->exists();
    }

    /**
     * Scope pour les médecins avec compte utilisateur
     */
    public function scopeWithUserAccount($query)
    {
        return $query->whereNotNull('user_id');
    }

    /**
     * Scope pour les médecins sans compte utilisateur
     */
    public function scopeWithoutUserAccount($query)
    {
        return $query->whereNull('user_id');
    }
}
