@extends('layouts.scratch')

@section('title', 'Détails de la Permission')

@section('page-title', 'Détails de la Permission')

@section('page-actions')
    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning">
        <i class="fas fa-edit"></i> Modifier
    </a>
@endsection

@push('styles')
    <style>
        .info-card .card-title {
            color: #495057;
            font-weight: 600;
        }
        .badge-role {
            font-size: 0.9em;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .permission-code {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 8px 12px;
            font-family: 'Courier New', monospace;
            font-size: 1.1em;
            color: #e83e8c;
        }
        .meta-info {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }
        .meta-item:last-child {
            margin-bottom: 0;
        }
        .meta-icon {
            width: 20px;
            margin-right: 10px;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
    <!-- Informations principales -->
    <div class="row">
        <div class="col-md-8">
            <div class="card info-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key"></i> Informations de la Permission
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nom de la permission</label>
                                <div class="permission-code">
                                    {{ $permission->name }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nom d'affichage</label>
                                <p class="form-control-plaintext">
                                    {{ $permission->display_name ?: 'Non défini' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Description</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $permission->description ?: 'Aucune description fournie.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-info-circle"></i> Métadonnées
                    </h6>
                </div>
                <div class="card-body">
                    <div class="meta-info">
                        <div class="meta-item">
                            <i class="fas fa-hashtag meta-icon"></i>
                            <span><strong>ID:</strong> {{ $permission->id }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-plus meta-icon"></i>
                            <span><strong>Créée:</strong> {{ $permission->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-edit meta-icon"></i>
                            <span><strong>Modifiée:</strong> {{ $permission->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        @if($permission->roles->count() > 0)
                            <div class="meta-item">
                                <i class="fas fa-users meta-icon"></i>
                                <span><strong>Utilisée par:</strong> {{ $permission->roles->count() }} rôle(s)</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rôles utilisant cette permission -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-users-cog"></i> Rôles utilisant cette permission
            </h6>
        </div>
        <div class="card-body">
            @if($permission->roles->count() > 0)
                <div class="row">
                    @foreach($permission->roles as $role)
                        <div class="col-md-4 mb-3">
                            <div class="card border-left-primary">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-user-tag fa-lg text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $role->display_name ?: $role->name }}</h6>
                                            <small class="text-muted">
                                                <code>{{ $role->name }}</code>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Cette permission est assignée à <strong>{{ $permission->roles->count() }}</strong> rôle(s).
                    La suppression de cette permission nécessitera de la retirer de tous ces rôles.
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Permission non utilisée</strong><br>
                    Cette permission n'est assignée à aucun rôle. Vous pouvez l'assigner à des rôles pour qu'elle devienne active.
                </div>

                <div class="text-center">
                    <p class="text-muted mb-3">Cette permission peut être supprimée sans impact sur le système.</p>
                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette permission ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer cette permission
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Utilisateurs ayant cette permission -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-users"></i> Utilisateurs ayant cette permission
            </h6>
        </div>
        <div class="card-body">
            @php
                // Récupérer tous les utilisateurs ayant cette permission via leurs rôles
                $usersWithPermission = collect();
                foreach($permission->roles as $role) {
                    if($role->users) {
                        $usersWithPermission = $usersWithPermission->merge($role->users);
                    }
                }
                // Éliminer les doublons si un utilisateur a plusieurs rôles avec la même permission
                $usersWithPermission = $usersWithPermission->unique('id');
            @endphp

            @if($usersWithPermission->count() > 0)
                <div class="row">
                    @foreach($usersWithPermission as $user)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-left-success">
                                <div class="card-body py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            <i class="fas fa-user fa-lg text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                            <br>
                                            <small class="text-info">
                                                Via :
                                                @php
                                                    $userRolesWithPermission = $user->roles->intersect($permission->roles);
                                                @endphp
                                                @foreach($userRolesWithPermission as $role)
                                                    <span class="badge badge-info badge-sm">{{ $role->display_name ?: $role->name }}</span>
                                                @endforeach
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="alert alert-success ">
                    <i class="fas fa-check-circle "></i>
                    <strong>{{ $usersWithPermission->count() }}</strong> utilisateur(s) {{ $usersWithPermission->count() > 1 ? 'ont' : 'a' }} cette permission.
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Aucun utilisateur</strong><br>
                    Aucun utilisateur n'a actuellement cette permission.
                    @if($permission->roles->count() > 0)
                        Cela peut signifier que les rôles associés n'ont pas encore d'utilisateurs assignés.
                    @else
                        Assignez d'abord cette permission à des rôles, puis assignez des utilisateurs à ces rôles.
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-bolt"></i> Actions rapides
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Modifier cette permission
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i> Créer une nouvelle permission
                    </a>
                </div>
                <div class="col-md-4">
                    @if($permission->roles->count() == 0)
                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette permission ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    @else
                        <button class="btn btn-danger btn-block" disabled title="Impossible de supprimer - Permission utilisée par des rôles">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
