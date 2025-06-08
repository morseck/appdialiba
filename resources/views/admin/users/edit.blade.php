@extends('layouts.scratch')

@section('title', 'Modifier un Utilisateur')

@section('page-title', 'Modifier l\'Utilisateur')
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
    <a href="{{ route('users.show', $user) }}" class="btn btn-info">
        <i class="fas fa-eye"></i> Voir
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-edit"></i> Modifier : {{ $user->name }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nom complet <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Prénom Nom"
                                   required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Adresse email <span class="text-danger">*</span></label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="utilisateur@exemple.com"
                                   required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Nouveau mot de passe</label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Laisser vide pour ne pas changer">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                            <small class="form-text text-muted">
                                Minimum 6 caractères. Laisser vide pour conserver le mot de passe actuel.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Répéter le nouveau mot de passe">
                        </div>
                    </div>
                </div>

                <!-- Statut Administrateur -->
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox"
                               name="is_admin"
                               id="is_admin"
                               class=""
                               value="1"
                            {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">
                            <strong>Administrateur système</strong>
                            <small class="text-muted d-block">
                                Cet utilisateur aura tous les droits d'administration
                            </small>
                        </label>
                    </div>
                </div>

                <!-- Attribution des rôles -->
                <div class="form-group">
                    <label>Rôles attribués</label>
                    @if($roles->count() > 0)
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($roles as $role)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                       name="roles[]"
                                                       id="role_{{ $role->id }}"
                                                       class=""
                                                       value="{{ $role->id }}"
                                                    {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="role_{{ $role->id }}">
                                                    @if($user->roles->contains($role->id))
                                                        <span class="badge badge-success badge-sm">Actuel</span>
                                                    @endif
                                                        <br>
                                                    <strong>{{ $role->display_name ?: $role->name }}</strong>
                                                    @if($role->description)
                                                        <small class="text-muted d-block">{{ $role->description }}</small>
                                                    @endif

                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @if($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Aucun rôle disponible. <a href="{{ route('roles.create') }}">Créer un rôle</a>
                        </div>
                    @endif
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Informations sur l'utilisateur -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-info-circle"></i> Informations sur l'utilisateur
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Créé le :</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
                    <p><strong>Dernière modification :</strong> {{ $user->updated_at->format('d/m/Y à H:i') }}</p>
                    <p><strong>Email vérifié :</strong>
                        @if($user->email_verified_at)
                            <span class="badge badge-success">Oui</span>
                            <small class="text-muted">({{ $user->email_verified_at->format('d/m/Y') }})</small>
                        @else
                            <span class="badge badge-warning">Non</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Statut :</strong>
                        @if($user->is_admin)
                            <span class="badge badge-danger">Administrateur</span>
                        @else
                            <span class="badge badge-info">Utilisateur</span>
                        @endif
                    </p>
                    <p><strong>Rôles actuels :</strong>
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                <span class="badge badge-primary">{{ $role->display_name ?: $role->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">Aucun rôle</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Validation en temps réel des mots de passe
            $('#password_confirmation').on('keyup', function() {
                var password = $('#password').val();
                var confirm = $(this).val();

                if (password && password != confirm) {
                    $(this).addClass('is-invalid');
                    if ($('#password-match-error').length == 0) {
                        $(this).after('<div id="password-match-error" class="invalid-feedback">Les mots de passe ne correspondent pas</div>');
                    }
                } else {
                    $(this).removeClass('is-invalid');
                    $('#password-match-error').remove();
                }
            });

            // Avertissement si admin est coché
            $('#is_admin').on('change', function() {
                if ($(this).is(':checked')) {
                    if ($('#admin-warning').length == 0) {
                        $(this).closest('.form-group').append(
                            '<div id="admin-warning" class="alert alert-warning mt-2">' +
                            '<i class="fas fa-exclamation-triangle"></i> ' +
                            'Attention : Un administrateur système a accès à toutes les fonctionnalités.' +
                            '</div>'
                        );
                    }
                } else {
                    $('#admin-warning').remove();
                }
            });

            // Highlight des changements de rôles
            $('input[name="roles[]"]').on('change', function() {
                var label = $(this).next('label');
                if ($(this).is(':checked')) {
                    if (!label.find('.badge-success').length) {
                        label.find('.badge').removeClass('badge-success').addClass('badge-warning').text('Nouveau');
                    }
                } else {
                    if (label.find('.badge-success').length) {
                        label.find('.badge').removeClass('badge-success').addClass('badge-danger').text('À retirer');
                    }
                }
            });
        });
    </script>
@endsection
