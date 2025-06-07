
@extends('layouts.scratch')

@section('title', 'Créer un utilisateur')
@section('page-title', 'Créer un utilisateur')

@section('page-actions')
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
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
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required placeholder="ex: Jean Dupont">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">Adresse email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required placeholder="ex: jean.dupont@exemple.com">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                   required placeholder="Minimum 6 caractères">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                   required placeholder="Répétez le mot de passe">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_admin" name="is_admin" value="1"
                                    {{ old('is_admin') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_admin">
                                    <strong>Administrateur système</strong>
                                    <br><small class="text-muted">L'utilisateur aura tous les droits d'administration</small>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Rôles</label>
                            <div class="card">
                                <div class="card-body">
                                    @if($roles->count() > 0)
                                        <div class="row">
                                            @foreach($roles as $role)
                                                <div class="col-md-6 mb-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="role_{{ $role->id }}"
                                                               name="roles[]"
                                                               value="{{ $role->id }}"
                                                            {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="role_{{ $role->id }}">
                                                            <strong>{{ $role->display_name ?: $role->name }}</strong>
                                                            @if($role->description)
                                                                <br><small class="text-muted">{{ $role->description }}</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Aucun rôle disponible. <a href="{{ route('roles.create') }}">Créer un rôle</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer l'utilisateur
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-info-circle"></i> Aide</h6>
                </div>
                <div class="card-body">
                    <h6>Conseils pour créer un utilisateur :</h6>
                    <ul class="small">
                        <li>L'<strong>email</strong> doit être unique dans le système</li>
                        <li>Le <strong>mot de passe</strong> doit contenir au moins 6 caractères</li>
                        <li>Un utilisateur <strong>admin</strong> a tous les droits</li>
                        <li>Les <strong>rôles</strong> définissent les permissions spécifiques</li>
                        <li>Un utilisateur peut avoir plusieurs rôles</li>
                    </ul>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0"><i class="fas fa-shield-alt"></i> Sécurité</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Le mot de passe sera automatiquement chiffré lors de l'enregistrement.
                        L'utilisateur pourra le modifier une fois connecté.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
