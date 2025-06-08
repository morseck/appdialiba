<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Loggable;

    protected $fillable = [
        'name', 'email', 'password','is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        // Charger les rôles si ils ne sont pas déjà chargés
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        // Vérifier que la collection existe
        if ($this->roles === null || $this->roles->isEmpty()) {
            return false;
        }

        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return $this->roles->contains('id', $role->id);
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            return $this->hasRole($roles);
        }

        return false;
    }

    public function hasPermission($permission)
    {
        // Charger les rôles avec leurs permissions si pas déjà chargés
        if (!$this->relationLoaded('roles')) {
            $this->load('roles.permissions');
        }

        // Vérifier que la collection existe
        if ($this->roles === null || $this->roles->isEmpty()) {
            return false;
        }

        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }

        return false;
    }



    /**
     * Méthode pour vérifier si l'utilisateur a des rôles
     */
    public function hasRoles()
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        return $this->roles !== null && $this->roles->isNotEmpty();
    }

    /**
     * Obtenir tous les noms des rôles de l'utilisateur
     */
    public function getRoleNames()
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        if ($this->roles === null) {
            return collect();
        }

        return $this->roles->pluck('name');
    }

    /**
     * Obtenir toutes les permissions de l'utilisateur via ses rôles
     */
    public function getAllPermissions()
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles.permissions');
        }

        if ($this->roles === null || $this->roles->isEmpty()) {
            return collect();
        }

        $permissions = collect();

        foreach ($this->roles as $role) {
            if ($role->permissions !== null) {
                $permissions = $permissions->merge($role->permissions);
            }
        }

        return $permissions->unique('id');
    }

    /**
     * Vérifier si l'utilisateur a toutes les permissions données
     */
    public function hasAllPermissions($permissions)
    {
        if (is_string($permissions)) {
            $permissions = [$permissions];
        }

        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Assigner un rôle de manière sécurisée
     */
    public function assignRole($role)
    {
        if (is_string($role)) {
            $roleModel = Role::where('name', $role)->first();
            if (!$roleModel) {
                throw new \Exception("Le rôle '{$role}' n'existe pas.");
            }
            $role = $roleModel;
        }

        if ($role && !$this->hasRole($role)) {
            $this->roles()->attach($role->id);
            // Recharger les relations pour éviter les problèmes de cache
            $this->load('roles');
        }

        return $this;
    }

    /**
     * Retirer un rôle de manière sécurisée
     */
    public function removeRole($role)
    {
        if (is_string($role)) {
            $roleModel = Role::where('name', $role)->first();
            if (!$roleModel) {
                return $this; // Pas d'erreur si le rôle n'existe pas
            }
            $role = $roleModel;
        }

        if ($role && $this->hasRole($role)) {
            $this->roles()->detach($role->id);
            // Recharger les relations pour éviter les problèmes de cache
            $this->load('roles');
        }

        return $this;
    }

    /**
     * Synchroniser les rôles de l'utilisateur
     */
    public function syncRoles($roles)
    {
        $roleIds = collect();

        foreach ($roles as $role) {
            if (is_string($role)) {
                $roleModel = Role::where('name', $role)->first();
                if ($roleModel) {
                    $roleIds->push($roleModel->id);
                }
            } elseif (is_object($role) && isset($role->id)) {
                $roleIds->push($role->id);
            } elseif (is_numeric($role)) {
                $roleIds->push($role);
            }
        }

        $this->roles()->sync($roleIds->toArray());
        $this->load('roles');

        return $this;
    }


    /**
     * Scope pour charger automatiquement les rôles
     */
    public function scopeWithRoles($query)
    {
        return $query->with('roles');
    }

    /**
     * Scope pour charger les rôles avec leurs permissions
     */
    public function scopeWithRolesAndPermissions($query)
    {
        return $query->with('roles.permissions');
    }

    /**
     * Scope pour les utilisateurs ayant un rôle spécifique
     */
    public function scopeWithRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            if (is_string($role)) {
                $q->where('name', $role);
            } else {
                $q->where('id', $role);
            }
        });
    }

    /**
     * Scope pour les utilisateurs ayant une permission spécifique
     */
    public function scopeWithPermission($query, $permission)
    {
        return $query->whereHas('roles.permissions', function ($q) use ($permission) {
            if (is_string($permission)) {
                $q->where('name', $permission);
            } else {
                $q->where('id', $permission);
            }
        });
    }
}
