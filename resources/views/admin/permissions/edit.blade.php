@extends('layouts.scratch')

@section('title', 'Modifier une Permission')

@section('page-title', 'Modifier la Permission')

@section('page-actions')
    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
    <a href="{{ route('permissions.show', $permission) }}" class="btn btn-info">
        <i class="fas fa-eye"></i> Voir
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-edit"></i> Modifier la Permission : {{ $permission->display_name ?: $permission->name }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('permissions.update', $permission) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nom de la permission <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $permission->name) }}"
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
                                   value="{{ old('display_name', $permission->display_name) }}"
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
                              placeholder="Description détaillée de cette permission...">{{ old('description', $permission->description) }}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Informations sur l'utilisation de la permission -->
    <div class="card mt-4">
        <div class="card-header">
            <h6 class="card-title mb-0">
                <i class="fas fa-info-circle"></i> Utilisation de cette permission
            </h6>
        </div>
        <div class="card-body">
            @if($permission->roles->count() > 0)
                <h6>Rôles utilisant cette permission :</h6>
                <div class="row">
                    @foreach($permission->roles as $role)
                        <div class="col-md-3 mb-2">
                        <span class="badge badge-info">
                            {{ $role->display_name ?: $role->name }}
                        </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cette permission n'est assignée à aucun rôle.
                </div>
            @endif

            <div class="mt-3">
                <small class="text-muted">
                    <i class="fas fa-clock"></i>
                    Créée le {{ $permission->created_at->format('d/m/Y à H:i') }}
                    @if($permission->updated_at != $permission->created_at)
                        | Modifiée le {{ $permission->updated_at->format('d/m/Y à H:i') }}
                    @endif
                </small>
            </div>
        </div>
    </div>
@endsection
