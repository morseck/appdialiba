<?php

namespace App;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Loggable;

    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function hasPermission($permission)
    {
        // Charger les permissions si elles ne sont pas déjà chargées
        if (!$this->relationLoaded('permissions')) {
            $this->load('permissions');
        }

        // Vérifier que la collection existe
        if ($this->permissions === null || $this->permissions->isEmpty()) {
            return false;
        }

        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }

        return $this->permissions->contains('id', $permission->id);
    }
}

