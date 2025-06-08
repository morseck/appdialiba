@extends('layouts.scratch')

@section('title', 'Logs de Transaction')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-list"></i> Logs de Transaction
                            <div class="pull-right">
                                <a href="{{ route('transaction-logs.export', request()->query()) }}" class="btn btn-success btn-sm">
                                    <i class="fa fa-download"></i> Exporter CSV
                                </a>
                            </div>
                        </h3>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="panel-body" style="background-color: #f9f9f9; border-bottom: 1px solid #ddd;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stat-box text-center">
                                    <h4 class="text-primary">{{ $stats['total_today'] }}</h4>
                                    <small>Aujourd'hui</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box text-center">
                                    <h4 class="text-info">{{ $stats['total_week'] }}</h4>
                                    <small>Cette semaine</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box text-center">
                                    <h4 class="text-warning">{{ $stats['total_month'] }}</h4>
                                    <small>Ce mois</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-box text-center">
                                    <small>Actions du mois:</small><br>
                                    @foreach($stats['by_action'] as $action => $count)
                                        <span class="label label-default">{{ ucfirst($action) }}: {{ $count }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div class="card">
                        <div class="card-body">
                            <div class="panel-body ">
                                <form method="GET" style="display: flex; flex-wrap: wrap; gap: 16px;">
                                    <div style="display: flex; flex-direction: column;">
                                        <label style="margin-bottom: 4px;">Modèle:</label>
                                        <select name="model_type" class="form-control input-sm">
                                            <option value="">Tous les modèles</option>
                                            @foreach($modelTypes as $type)
                                                <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                                    {{ class_basename($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <label style="margin-bottom: 4px;">Action:</label>
                                        <select name="action" class="form-control input-sm">
                                            <option value="">Toutes les actions</option>
                                            @foreach($actions as $action)
                                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                                    {{ ucfirst($action) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <label style="margin-bottom: 4px;">Utilisateur:</label>
                                        <select name="user_id" class="form-control input-sm">
                                            <option value="">Tous les utilisateurs</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <label style="margin-bottom: 4px;">Du:</label>
                                        <input type="date" name="date_from" class="form-control input-sm" value="{{ request('date_from') }}">
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <label style="margin-bottom: 4px;">Au:</label>
                                        <input type="date" name="date_to" class="form-control input-sm" value="{{ request('date_to') }}">
                                    </div>

                                    <div style="display: flex; flex-direction: column;">
                                        <label style="margin-bottom: 4px;">Recherche:</label>
                                        <input type="text" name="search" class="form-control input-sm" placeholder="Rechercher..." value="{{ request('search') }}">
                                    </div>

                                    <div style="align-self: end;">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-filter"></i> Filtrer
                                        </button>

                                        <a href="{{ route('transaction-logs.index') }}" class="btn btn-default btn-sm">
                                            <i class="fa fa-refresh"></i> Réinitialiser
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>






                    <!-- Table des logs -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>Date/Heure</th>
                                <th>Action</th>
                                <th>Modèle</th>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>IP</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td>
                                        <small>{{ $log->created_at->format('d/m/Y') }}</small><br>
                                        <strong>{{ $log->created_at->format('H:i:s') }}</strong>
                                    </td>
                                    <td>
                                        @if($log->action == 'create')
                                            <span class="label label-success">Création</span>
                                        @elseif($log->action == 'update')
                                            <span class="label label-warning">Modification</span>
                                        @elseif($log->action == 'delete')
                                            <span class="label label-danger">Suppression</span>
                                        @else
                                            <span class="label label-info">{{ ucfirst($log->action) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ class_basename($log->model_type) }}</strong>
                                    </td>
                                    <td>
                                        @if($log->model_id)
                                            <code>#{{ $log->model_id }}</code>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->user)
                                            <strong>{{ $log->user->name }}</strong><br>
                                            <small class="text-muted">{{ $log->user->email }}</small>
                                        @elseif($log->user_name)
                                            <strong>{{ $log->user_name }}</strong><br>
                                            <small class="text-muted">{{ $log->user_email }}</small>
                                        @else
                                            <span class="text-muted">Système</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->ip_address)
                                            <small><code>{{ $log->ip_address }}</code></small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->description)
                                            {{ str_limit($log->description, 50) }}
                                        @else
                                            {{ str_limit($log->getFormattedDescription(), 50) }}
                                        @endif

                                        @if($log->changes && count($log->changes) > 0)
                                            <br><small class="text-info">
                                                <i class="fa fa-edit"></i> {{ count($log->changes) }} champ(s) modifié(s)
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('transaction-logs.show', $log->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        <i class="fa fa-info-circle"></i> Aucun log trouvé
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($logs->hasPages())
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        Affichage de {{ $logs->firstItem() }} à {{ $logs->lastItem() }}
                                        sur {{ $logs->total() }} résultats
                                    </small>
                                </div>
                                <div class="col-md-6 text-right">
                                    {{ $logs->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-box {
            padding: 10px;
            margin: 5px 0;
        }

        .stat-box h4 {
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .form-inline .form-group {
            margin-right: 15px;
            margin-bottom: 10px;
        }

        .form-inline label {
            margin-right: 5px;
            font-weight: normal;
        }

        .table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .table td {
            vertical-align: middle;
        }

        .label {
            font-size: 11px;
        }
    </style>
@endsection
