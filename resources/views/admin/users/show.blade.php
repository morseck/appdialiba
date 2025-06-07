@extends('layouts.scratch')

@section('title', 'Détails de l\'Utilisateur')

@section('page-title', 'Utilisateur : ' . $user->name)

@push('styles')
    <style>
        .form-group label{
            color: black;
        }
        label{
            color: black;
        }
    </style>
@endpush

@section('page-actions')
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> Modifier
    </a>
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
        <i class="fas fa-trash"></i> Supprimer
    </button>
@endsection

@section('content')
    <!-- Informations générales -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-user"></i> Informations générales
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nom :</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email :</th>
                            <td>
                                {{ $user->email }}
                                @if($user->email_verified_at)
                                    <span class="badge badge-success ml-2">Vérifié</span>
                                @else
                                    <span class="badge badge-warning ml-2">Non vérifié</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Statut :</th>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge badge-danger">
                                    <i class="fas fa-crown"></i> Administrateur
                                </span>
                                @else
                                    <span class="badge badge-info">
                                    <i class="fas fa-user"></i> Utilisateur
                                </span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Créé le :</th>
                            <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Modifié le :</th>
                            <td>{{ $user->updated_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                        @if($user->email_verified_at)
                            <tr>
                                <th>Email vérifié le :</th>
                                <td>{{ $user->email_verified_at->format('d/m/Y à H:i') }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Rôles attribués -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-tag"></i> Rôles attribués
                <span class="badge badge-secondary">{{ $user->roles->count() }}</span>
            </h5>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#assignRolesModal">
                <i class="fas fa-plus"></i> Gérer les rôles
            </button>
        </div>
        <div class="card-body">
            @if($user->roles->count() > 0)
                <div class="row">
                    @foreach($user->roles as $role)
                        <div class="col-md-6 mb-3">
                            <div class="card border-primary">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="card-title mb-1">{{ $role->display_name ?: $role->name }}</h6>
                                            @if($role->description)
                                                <p class="card-text text-muted small mb-2">{{ $role->description }}</p>
                                            @endif
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-key"></i>
                                                    {{ $role->permissions->count() }} permission(s)
                                                </small>
                                            </p>
                                        </div>
                                        <form action="{{ route('users.remove-role', [$user, $role]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Retirer ce rôle ?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Cet utilisateur n'a aucun rôle attribué.
                    <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#assignRolesModal">
                        Attribuer des rôles
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Permissions effectives -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-key"></i> Permissions effectives
                <span class="badge badge-secondary">{{ $user->roles->flatMap->permissions->unique('id')->count() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @php
                $allPermissions = $user->roles->flatMap->permissions->unique('id');
            @endphp

            @if($user->is_admin)
                <div class="alert alert-warning">
                    <i class="fas fa-crown"></i>
                    <strong>Administrateur système :</strong> Cet utilisateur a accès à toutes les fonctionnalités, indépendamment des permissions ci-dessous.
                </div>
            @endif

            @if($allPermissions->count() > 0)
                <div class="row">
                    @foreach($allPermissions->groupBy(function($permission) {
                        return explode('-', $permission->name)[0];
                    }) as $group => $permissions)
                        <div class="col-md-4 mb-3">
                            <h6 class="text-uppercase text-muted">{{ ucfirst($group) }}</h6>
                            @foreach($permissions as $permission)
                                <span class="badge badge-info d-block mb-1 text-left">
                                {{ $permission->display_name ?: $permission->name }}
                            </span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cet utilisateur n'a aucune permission spécifique attribuée via ses rôles.
                </div>
            @endif
        </div>
    </div>

    <!-- Modal pour assigner des rôles -->
    <div class="modal fade" id="assignRolesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('users.assign-roles', $user) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Gérer les rôles de {{ $user->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @php
                            $availableRoles = \App\Role::all();
                        @endphp

                        @if($availableRoles->count() > 0)
                            <div class="row">
                                @foreach($availableRoles as $role)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                   name="roles[]"
                                                   id="modal_role_{{ $role->id }}"
                                                   class=""
                                                   value="{{ $role->id }}"
                                                {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="modal_role_{{ $role->id }}">
                                                <strong>{{ $role->display_name ?: $role->name }}</strong>
                                                @if($role->description)
                                                    <small class="text-muted d-block">{{ $role->description }}</small>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                Aucun rôle disponible.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmer la suppression</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ $user->name }}</strong> ?</p>
                    <p class="text-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        Cette action est irréversible.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
