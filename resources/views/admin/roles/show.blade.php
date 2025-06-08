@extends('layouts.scratch')

@section('title', 'Détails du Rôle')

@section('page-title', 'Rôle : ' . ($role->display_name ?: $role->name))

@section('page-actions')
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">
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
                <i class="fas fa-user-tag"></i> Informations générales
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Nom :</th>
                            <td><code>{{ $role->name }}</code></td>
                        </tr>
                        <tr>
                            <th>Nom d'affichage :</th>
                            <td>{{ $role->display_name ?: 'Non défini' }}</td>
                        </tr>
                        <tr>
                            <th>Description :</th>
                            <td>{{ $role->description ?: 'Aucune description' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150">Créé le :</th>
                            <td>{{ $role->created_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Modifié le :</th>
                            <td>{{ $role->updated_at->format('d/m/Y à H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Utilisateurs :</th>
                            <td>
                                <span class="badge badge-info">{{ $role->users->count() }}</span>
                                utilisateur(s) avec ce rôle
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Permissions attribuées -->
    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-key"></i> Permissions attribuées
                <span class="badge badge-secondary">{{ $role->permissions->count() }}</span>
            </h5>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#assignPermissionsModal">
                <i class="fas fa-plus"></i> Gérer les permissions
            </button>
        </div>
        <div class="card-body">
            @if($role->permissions->count() > 0)
                <div class="row">
                    @foreach($role->permissions->groupBy(function($permission) {
                        return explode('-', $permission->name)[0];
                    }) as $group => $permissions)
                        <div class="col-md-4 mb-4">
                            <h6 class="text-uppercase text-muted border-bottom pb-2">
                                <i class="fas fa-folder"></i> {{ ucfirst($group) }}
                            </h6>
                            @foreach($permissions as $permission)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <strong>{{ $permission->display_name ?: $permission->name }}</strong>
                                        @if($permission->description)
                                            <small class="text-muted d-block">{{ $permission->description }}</small>
                                        @endif
                                    </div>
                                    <form action="{{ route('roles.remove-permission', [$role, $permission]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Retirer cette permission ?')"
                                                title="Retirer cette permission">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Ce rôle n'a aucune permission attribuée.
                    <button type="button" class="btn btn-sm btn-primary ml-2" data-toggle="modal" data-target="#assignPermissionsModal">
                        Attribuer des permissions
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Utilisateurs ayant ce rôle -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users"></i> Utilisateurs ayant ce rôle
                <span class="badge badge-secondary">{{ $role->users->count() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($role->users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Autres rôles</th>
                            <th width="100">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($role->users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->isAdmin)
                                        <span class="badge badge-danger">Admin</span>
                                    @else
                                        <span class="badge badge-info">User</span>
                                    @endif
                                </td>
                                <td>
                                    @foreach($user->roles->where('id', '!=', $role->id) as $otherRole)
                                        <span class="badge badge-secondary">{{ $otherRole->display_name ?: $otherRole->name }}</span>
                                    @endforeach
                                    @if($user->roles->where('id', '!=', $role->id)->count() == 0)
                                        <span class="text-muted">Aucun autre rôle</span>
                                        @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('users.remove-role', [$user, $role]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Retirer ce rôle à {{ $user->name }} ?')"
                                                title="Retirer ce rôle">
                                            <i class="fas fa-user-minus"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    Aucun utilisateur n'a ce rôle pour le moment.
                </div>
            @endif
        </div>
    </div>

    <!-- Modal pour gérer les permissions -->
    <div class="modal fade" id="assignPermissionsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-key"></i> Gérer les permissions pour "{{ $role->display_name ?: $role->name }}"
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('roles.assign-permissions', $role) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Rechercher une permission :</label>
                            <input type="text" id="permissionSearch" class="form-control" placeholder="Tapez pour filtrer les permissions...">
                        </div>

                        <div class="row">
                            @php
                                $allPermissions = \App\Permission::all()->groupBy(function($permission) {
                                    return explode('-', $permission->name)[0];
                                });
                            @endphp

                            @foreach($allPermissions as $group => $permissions)
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header py-2">
                                            <h6 class="mb-0 text-uppercase">
                                                <i class="fas fa-folder"></i> {{ ucfirst($group) }}
                                                <div class="float-right">
                                                    <button type="button" class="btn btn-sm btn-outline-primary select-all-group"
                                                            data-group="{{ $group }}">
                                                        Tout sélectionner
                                                    </button>
                                                </div>
                                            </h6>
                                        </div>
                                        <div class="card-body py-2">
                                            @foreach($permissions as $permission)
                                                <div class="form-check permission-item" data-permission="{{ strtolower($permission->name) }}">
                                                    <input class="group-{{ $group }}"
                                                           type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ $permission->id }}"
                                                           id="permission_{{ $permission->id }}"
                                                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        <strong>{{ $permission->display_name ?: $permission->name }}</strong>
                                                        @if($permission->description)
                                                            <small class="text-muted d-block">{{ $permission->description }}</small>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer les permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-warning"></i> Confirmer la suppression
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer le rôle <strong>"{{ $role->display_name ?: $role->name }}"</strong> ?</p>

                    @if($role->users->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Attention :</strong> Ce rôle est actuellement attribué à {{ $role->users->count() }} utilisateur(s).
                            La suppression retirera automatiquement ce rôle de tous les utilisateurs concernés.
                        </div>
                    @endif

                    <p class="text-muted">Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts-scroll')
    <script>
        $(document).ready(function() {
            // Recherche de permissions dans le modal
            $('#permissionSearch').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.permission-item').each(function() {
                    const permissionName = $(this).data('permission');
                    const permissionText = $(this).find('label').text().toLowerCase();

                    if (permissionName.includes(searchTerm) || permissionText.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Sélectionner/désélectionner toutes les permissions d'un groupe
            $('.select-all-group').on('click', function() {
                const group = $(this).data('group');
                const checkboxes = $(`.group-${group}`);
                const allChecked = checkboxes.length === checkboxes.filter(':checked').length;

                checkboxes.prop('checked', !allChecked);
                $(this).text(allChecked ? 'Tout sélectionner' : 'Tout désélectionner');
            });

            // Mettre à jour le texte du bouton "Tout sélectionner" au changement
            $('input[type="checkbox"]').on('change', function() {
                const className = $(this).attr('class').match(/group-\w+/);
                if (className) {
                    const group = className[0].replace('group-', '');
                    const checkboxes = $(`.group-${group}`);
                    const allChecked = checkboxes.length === checkboxes.filter(':checked').length;

                    $(`.select-all-group[data-group="${group}"]`).text(
                        allChecked ? 'Tout désélectionner' : 'Tout sélectionner'
                    );
                }
            });

            // Initialiser l'état des boutons "Tout sélectionner"
            $('.select-all-group').each(function() {
                const group = $(this).data('group');
                const checkboxes = $(`.group-${group}`);
                const allChecked = checkboxes.length === checkboxes.filter(':checked').length;

                $(this).text(allChecked ? 'Tout désélectionner' : 'Tout sélectionner');
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .permission-item {
            border-bottom: 1px solid #f8f9fa;
            padding: 8px 0;
        }

        .permission-item:last-child {
            border-bottom: none;
        }

        .form-check-label {
            cursor: pointer;
            width: 100%;
        }

        .card-header h6 {
            color: #495057;
            font-weight: 600;
        }

        .badge {
            font-size: 0.75em;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .alert {
            border: none;
            border-radius: 8px;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .modal-lg {
            max-width: 900px;
        }

        @media (max-width: 768px) {
            .col-md-4, .col-md-6 {
                margin-bottom: 1rem;
            }

            .modal-lg {
                max-width: 95%;
                margin: 1rem auto;
            }
        }
    </style>
@endpush
