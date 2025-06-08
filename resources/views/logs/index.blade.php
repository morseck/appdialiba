@extends('layouts.scratch')

@section('title', 'Visualiseur de Logs')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-alt"></i>
                            Fichiers de Logs Laravel
                        </h3>
                        <div class="card-tools">
                            <form method="POST" action="{{ route('logs.clear') }}" style="display: inline;"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir vider tous les logs ?');">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">
                                    <i class="fas fa-broom"></i> Vider tous les logs
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(empty($logFiles))
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Aucun fichier de log trouvé.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nom du fichier</th>
                                        <th>Taille</th>
                                        <th>Dernière modification</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($logFiles as $file)
                                        <tr>
                                            <td>
                                                <i class="fas fa-file-alt text-primary"></i>
                                                <strong>{{ $file['name'] }}</strong>
                                            </td>
                                            <td>{{ $file['size'] }}</td>
                                            <td>
                                                {{ $file['modified'] }}
                                                <small class="text-muted">({{ $file['modified_diff'] }})</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('logs.show', $file['name']) }}"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye"></i> Voir
                                                    </a>
                                                    <a href="{{ route('logs.download', $file['name']) }}"
                                                       class="btn btn-success btn-sm">
                                                        <i class="fas fa-download"></i> Télécharger
                                                    </a>
                                                    <form method="POST"
                                                          action="{{ route('logs.delete', $file['name']) }}"
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border: none;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }
    </style>
@endsection
