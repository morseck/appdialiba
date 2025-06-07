@extends('layouts.scratch')

@section('title', 'Créer un rôle')
@section('page-title', 'Créer un rôle')

@section('page-actions')
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
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
        <div class="col-md-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nom du rôle <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required placeholder="ex: admin, user, manager">
                            <small class="form-text text-muted">Nom technique du rôle (utilisé dans le code)</small>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="display_name">Nom d'affichage</label>
                            <input type="text" name="display_name" id="display_name" class="form-control @error('display_name') is-invalid @enderror"
                                   value="{{ old('display_name') }}" placeholder="ex: Administrateur">
                            <small class="form-text text-muted">Nom affiché dans l'interface utilisateur</small>
                            @if($errors->has('display_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('display_name') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="3" placeholder="Description du rôle...">{{ old('description') }}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Permissions</label>
                            <div class="card">
                                <div class="card-body">
                                    @if($permissions->count() > 0)
                                        <div class="row">
                                            @foreach($permissions as $permission)
                                                <div class="col-md-6 mb-2">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="permission_{{ $permission->id }}"
                                                               name="permissions[]"
                                                               value="{{ $permission->id }}"
                                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="permission_{{ $permission->id }}">
                                                            <strong>{{ $permission->display_name ?: $permission->name }}</strong>
                                                            @if($permission->description)
                                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions()">
                                            Tout sélectionner
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPermissions()">
                                            Tout désélectionner
                                        </button>
                                    @else
                                        <p class="text-muted mb-0">Aucune permission disponible. <a href="{{ route('permissions.create') }}">Créer une permission</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le rôle
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts-scroll')
    <script>
        function selectAllPermissions() {
            document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
                checkbox.checked = true;
            });
        }

        function deselectAllPermissions() {
            document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
                checkbox.checked = false;
            });
        }
    </script>
@endpush
