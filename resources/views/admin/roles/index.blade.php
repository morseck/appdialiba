@extends('layouts.scratch')

@section('title', 'Gestion des rôles')
@section('page-title', 'Gestion des rôles')

@section('page-actions')
    <a href="{{ route('roles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouveau rôle
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Nom d'affichage</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th>Utilisateurs</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td><code>{{ $role->name }}</code></td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ str_limit($role->description, 50) }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $role->permissions->count() }} permission(s)</span>
                                </td>
                                <td>
                                    <span class="badge badge-secondary">{{ $role->users->count() }} utilisateur(s)</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $roles->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-user-tag fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucun rôle trouvé</h5>
                    <p class="text-muted">Commencez par créer votre premier rôle.</p>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer un rôle
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
