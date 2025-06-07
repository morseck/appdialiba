@extends('layouts.scratch')

@section('title', 'Gestion des permissions')
@section('page-title', 'Gestion des permissions')

@section('page-actions')
    <a href="{{ route('permissions.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle permission
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            @if($permissions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Nom d'affichage</th>
                            <th>Description</th>
                            <th>Rôles</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>{{ $permission->id }}</td>
                                <td><code>{{ $permission->name }}</code></td>
                                <td>{{ $permission->display_name }}</td>
                                <td>{{ str_limit($permission->description, 50) }}</td>
                                <td>
                                    @if($permission->roles->count() > 0)
                                        @foreach($permission->roles as $role)
                                            <span class="badge badge-primary">{{ $role->display_name ?: $role->name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Aucun rôle</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('permissions.show', $permission) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette permission ?')">
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
                    {{ $permissions->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-key fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune permission trouvée</h5>
                    <p class="text-muted">Commencez par créer votre première permission.</p>
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Créer une permission
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection
