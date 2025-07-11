<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Loggable;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Relations avec les profils spécialisés
     */
    public function medecin()
    {
        return $this->hasOne(Medecin::class);
    }

    public function dieuw()
    {
        return $this->hasOne(Dieuw::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * Déterminer le type d'utilisateur
     */
    public function getUserType()
    {
        if ($this->medecin) {
            return 'medecin';
        } elseif ($this->dieuw) {
            return 'dieuw';
        } elseif ($this->is_admin) {
            return 'admin';
        } else {
            return 'user';
        }
    }

    /**
     * Obtenir le profil associé (médecin ou dieuw)
     */
    public function getProfile()
    {
        if ($this->medecin) {
            return $this->medecin;
        } elseif ($this->dieuw) {
            return $this->dieuw;
        }
        return null;
    }

    /**
     * Vérifier si l'utilisateur est un médecin
     */
    public function isMedecin()
    {
        return $this->medecin !== null;
    }

    /**
     * Vérifier si l'utilisateur est un dieuw
     */
    public function isDieuw()
    {
        return $this->dieuw !== null;
    }

    /**
     * Obtenir l'avatar approprié
     */
    public function getAvatarAttribute()
    {
        $profile = $this->getProfile();
        if ($profile && isset($profile->avatar)) {
            return $profile->avatar;
        } elseif ($profile && isset($profile->image)) {
            return $profile->image;
        }
        return 'default-avatar.png';
    }

    /**
     * Redirection après connexion selon le type d'utilisateur
     */
    public function getRedirectRoute()
    {
        switch ($this->getUserType()) {
            case 'medecin':
                return route('medecin.dashboard');
            case 'dieuw':
                return route('dieuw.dashboard');
            case 'admin':
                return route('admin.dashboard');
            default:
                return route('home');
        }
    }

    // Toutes les autres méthodes existantes restent identiques...
    public function hasRole($role)
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

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
        if (!$this->relationLoaded('roles')) {
            $this->load('roles.permissions');
        }

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

    public function hasRoles()
    {
        if (!$this->relationLoaded('roles')) {
            $this->load('roles');
        }

        return $this->roles !== null && $this->roles->isNotEmpty();
    }

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
            $this->load('roles');
        }

        return $this;
    }

    public function removeRole($role)
    {
        if (is_string($role)) {
            $roleModel = Role::where('name', $role)->first();
            if (!$roleModel) {
                return $this;
            }
            $role = $roleModel;
        }

        if ($role && $this->hasRole($role)) {
            $this->roles()->detach($role->id);
            $this->load('roles');
        }

        return $this;
    }

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

    public function scopeWithRoles($query)
    {
        return $query->with('roles');
    }

    public function scopeWithRolesAndPermissions($query)
    {
        return $query->with('roles.permissions');
    }

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
