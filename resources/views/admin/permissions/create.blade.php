@extends('layouts.scratch')

@section('title', 'Créer une Permission')

@section('page-title', 'Créer une Permission')

@section('page-actions')
    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
@endsection

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

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-key"></i> Nouvelle Permission
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nom de la permission <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}"
                                   placeholder="Ex: edit-users"
                                   required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">
                                Utilisez des tirets pour séparer les mots (ex: edit-users, delete-posts)
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="display_name">Nom d'affichage</label>
                            <input type="text"
                                   name="display_name"
                                   id="display_name"
                                   class="form-control @error('display_name') is-invalid @enderror"
                                   value="{{ old('display_name') }}"
                                   placeholder="Ex: Modifier les utilisateurs">
                            @if($errors->has('display_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('display_name') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">
                                Nom lisible pour l'interface utilisateur
                            </small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description"
                              id="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="Description détaillée de cette permission...">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Créer la Permission
                    </button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Exemples de permissions courantes -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-lightbulb"></i> Exemples de permissions courantes
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h6>Gestion des utilisateurs</h6>
                    <ul class="list-unstyled">
                        <li><code>view-users</code> - Voir les utilisateurs</li>
                        <li><code>create-users</code> - Créer des utilisateurs</li>
                        <li><code>edit-users</code> - Modifier les utilisateurs</li>
                        <li><code>delete-users</code> - Supprimer les utilisateurs</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Gestion des rôles</h6>
                    <ul class="list-unstyled">
                        <li><code>view-roles</code> - Voir les rôles</li>
                        <li><code>create-roles</code> - Créer des rôles</li>
                        <li><code>edit-roles</code> - Modifier les rôles</li>
                        <li><code>delete-roles</code> - Supprimer les rôles</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Administration</h6>
                    <ul class="list-unstyled">
                        <li><code>access-admin</code> - Accès administration</li>
                        <li><code>manage-permissions</code> - Gérer les permissions</li>
                        <li><code>view-logs</code> - Consulter les logs</li>
                        <li><code>backup-system</code> - Sauvegarder le système</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
