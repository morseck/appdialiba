@extends('layouts.scratch')

@section('title', 'Détail du Log #' . $log->id)


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Informations principales -->
               <div class="card">
                   <div class="card-body">
                       <div class="panel panel-default">
                           <div class="panel-heading">
                               <h3 class="panel-title">
                                   <i class="fa fa-info-circle"></i> Détail du Log #{{ $log->id }}
                                   <div class="pull-right">
                                       <a href="{{ route('transaction-logs.index') }}" class="btn btn-default btn-sm">
                                           <i class="fa fa-arrow-left"></i> Retour à la liste
                                       </a>
                                   </div>
                               </h3>
                           </div>
                           <div class="panel-body">
                               <div class="row">
                                   <div class="col-md-6">
                                       <table class="table table-bordered">
                                           <tr>
                                               <th width="30%">Date/Heure:</th>
                                               <td>
                                                   <strong>{{ $log->created_at->format('d/m/Y à H:i:s') }}</strong>
                                                   <br><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                                               </td>
                                           </tr>
                                           <tr>
                                               <th>Action:</th>
                                               <td>
                                                   @if($log->action == 'create')
                                                       <span class="label label-success label-lg">Création</span>
                                                   @elseif($log->action == 'update')
                                                       <span class="label label-warning label-lg">Modification</span>
                                                   @elseif($log->action == 'delete')
                                                       <span class="label label-danger label-lg">Suppression</span>
                                                   @else
                                                       <span class="label label-info label-lg">{{ ucfirst($log->action) }}</span>
                                                   @endif
                                               </td>
                                           </tr>
                                           <tr>
                                               <th>Modèle:</th>
                                               <td>
                                                   <strong>{{ class_basename($log->model_type) }}</strong>
                                                   <br><small class="text-muted">{{ $log->model_type }}</small>
                                               </td>
                                           </tr>
                                           <tr>
                                               <th>ID Modèle:</th>
                                               <td>
                                                   @if($log->model_id)
                                                       <code>#{{ $log->model_id }}</code>
                                                       @if($relatedModel)
                                                           <span class="label label-success">Existe</span>
                                                       @else
                                                           <span class="label label-default">Supprimé</span>
                                                       @endif
                                                   @else
                                                       <span class="text-muted">Aucun</span>
                                                   @endif
                                               </td>
                                           </tr>
                                       </table>
                                   </div>
                                   <div class="col-md-6">
                                       <table class="table table-bordered">
                                           <tr>
                                               <th width="30%">Utilisateur:</th>
                                               <td>
                                                   @if($log->user)
                                                       <strong>{{ $log->user->name }}</strong>
                                                       <br><small class="text-muted">{{ $log->user->email }}</small>
                                                   @elseif($log->user_name)
                                                       <strong>{{ $log->user_name }}</strong>
                                                       <br><small class="text-muted">{{ $log->user_email }}</small>
                                                   @else
                                                       <span class="text-muted">Système</span>
                                                   @endif
                                               </td>
                                           </tr>
                                           <tr>
                                               <th>Adresse IP:</th>
                                               <td>
                                                   @if($log->ip_address)
                                                       <code>{{ $log->ip_address }}</code>
                                                   @else
                                                       <span class="text-muted">Non disponible</span>
                                                   @endif
                                               </td>
                                           </tr>
                                           <tr>
                                               <th>User Agent:</th>
                                               <td>
                                                   @if($log->user_agent)

                                                       <small> {{ str_limit($log->user_agent, 50) }}</small>
                                                   @else
                                                       <span class="text-muted">Non disponible</span>
                                                   @endif
                                               </td>
                                           </tr>
                                           <tr>
                                               <th>Description:</th>
                                               <td>
                                                   @if($log->description)
                                                       {{ $log->description }}
                                                   @else
                                                       {{ $log->getFormattedDescription() }}
                                                   @endif
                                               </td>
                                           </tr>
                                       </table>
                                   </div>
                               </div>

                               @if($log->context)
                                   <div class="alert alert-info">
                                       <h5><i class="fa fa-info-circle"></i> Contexte supplémentaire:</h5>
                                       <pre>{{ json_encode($log->context, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                   </div>
                               @endif
                           </div>
                       </div>
                   </div>
               </div>

                <!-- Changements détaillés -->
                @if($log->changes && count($log->changes) > 0)
                   <div class="card">
                       <div class="card-body">
                           <div class="panel panel-warning">
                               <div class="panel-heading">
                                   <h4 class="panel-title">
                                       <i class="fa fa-edit"></i> Changements détaillés ({{ count($log->changes) }} champ(s))
                                   </h4>
                               </div>
                               <div class="panel-body">
                                   <div class="table-responsive">
                                       <table class="table table-striped">
                                           <thead>
                                           <tr>
                                               <th>Champ</th>
                                               <th>Ancienne valeur</th>
                                               <th>Nouvelle valeur</th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           @foreach($log->changes as $field => $change)
                                               <tr>
                                                   <td><strong>{{ $field }}</strong></td>
                                                   <td>
                                                       @if($change['old'] === null)
                                                           <span class="text-muted"><em>null</em></span>
                                                       @elseif($change['old'] === '')
                                                           <span class="text-muted"><em>vide</em></span>
                                                       @else
                                                           <code>{{str_limit($change['old'], 100) }}</code>
                                                       @endif
                                                   </td>
                                                   <td>
                                                       @if($change['new'] === null)
                                                           <span class="text-muted"><em>null</em></span>
                                                       @elseif($change['new'] === '')
                                                           <span class="text-muted"><em>vide</em></span>
                                                       @else
                                                           <code>{{ str_limit($change['new'], 100) }}</code>
                                                       @endif
                                                   </td>
                                               </tr>
                                           @endforeach
                                           </tbody>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                @endif

                <!-- Valeurs complètes -->
                @if($log->old_values || $log->new_values)
                    <div class="card">
                        <div class="card-body">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-database"></i> Valeurs complètes
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        @if($log->old_values)
                                            <div class="col-md-6">
                                                <h5>Anciennes valeurs:</h5>
                                                <pre class="pre-scrollable">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        @endif
                                        @if($log->new_values)
                                            <div class="col-md-6">
                                                <h5>Nouvelles valeurs:</h5>
                                                <pre class="pre-scrollable">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Navigation -->
                @if($previousLog || $nextLog)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-arrows-h"></i> Navigation
                            </h4>
                        </div>
                        <div class="panel-body">
                            @if($previousLog)
                                <a href="{{ route('transaction-logs.show', $previousLog->id) }}" class="btn btn-default btn-block">
                                    <i class="fa fa-arrow-left"></i> Log précédent
                                    <br><small>{{ $previousLog->created_at->format('d/m/Y H:i') }}</small>
                                </a>
                            @endif
                            @if($nextLog)
                                <a href="{{ route('transaction-logs.show', $nextLog->id) }}" class="btn btn-default btn-block">
                                    <i class="fa fa-arrow-right"></i> Log suivant
                                    <br><small>{{ $nextLog->created_at->format('d/m/Y H:i') }}</small>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Modèle associé -->
                @if($relatedModel)
                    <div class="card">
                        <div class="card-body">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <i class="fa fa-link"></i> Modèle associé
                                    </h4>
                                </div>
                                <div class="panel-body">
                                    <p><strong>{{ class_basename($log->model_type) }} #{{ $log->model_id }}</strong></p>

                                    @if(method_exists($relatedModel, 'fullname'))
                                        <p>{{ $relatedModel->fullname() }}</p>
                                    @endif

                                    @if($log->model_type == 'App\Talibe')
                                        <a href="{{ route('talibe.show', $relatedModel->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> Voir le Talibe
                                        </a>
                                    @elseif($log->model_type == 'App\Dieuw')
                                        <a href="{{ route('dieuw.show', $relatedModel->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-eye"></i> Voir le Dieuw
                                        </a>
                                    @elseif($log->model_type == 'App\User')
                                        <a href="{{ route('users.show', $relatedModel->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-user"></i> Voir l'utilisateur
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Logs du même modèle -->
                @if($relatedLogs && count($relatedLogs) > 1)
                   <div class="card">
                       <div class="card-body">
                           <div class="panel panel-default">
                               <div class="panel-heading">
                                   <h4 class="panel-title">
                                       <i class="fa fa-history"></i> Historique du modèle
                                       <span class="badge">{{ count($relatedLogs) }}</span>
                                   </h4>
                               </div>
                               <div class="panel-body">
                                   <div class="list-group" style="max-height: 300px; overflow-y: auto;">
                                       @foreach($relatedLogs as $relLog)
                                           <a href="{{ route('transaction-logs.show', $relLog->id) }}"
                                              class="list-group-item {{ $relLog->id == $log->id ? 'active' : '' }}">
                                               <div class="row">
                                                   <div class="col-xs-8">
                                                       @if($relLog->action == 'create')
                                                           <span class="label label-success">Creer</span>
                                                       @elseif($relLog->action == 'update')
                                                           <span class="label label-warning">Modifiier</span>
                                                       @elseif($relLog->action == 'delete')
                                                           <span class="label label-danger">Supprimer</span>
                                                       @else
                                                           <span class="label label-info">{{ substr($relLog->action, 0, 1) }}</span>
                                                       @endif
                                                       <small>{{ $relLog->created_at->format('d/m H:i') }}</small>
                                                   </div>
                                                   <div class="col-xs-4 text-right ml-2">
                                                       <small class="text-muted">
                                                           {{ $relLog->user_name ?: 'Système' }}
                                                       </small>
                                                   </div>
                                               </div>
                                           </a>
                                       @endforeach
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                @endif

                <!-- Actions rapides -->
                <div class="card">
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="fa fa-cogs"></i> Actions
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="btn-group-vertical btn-block">
                                    <a href="{{ route('transaction-logs.index') }}" class="btn btn-default">
                                        <i class="fa fa-list"></i> Tous les logs
                                    </a>

                                    @if($log->user_id)
                                        <a href="{{ route('transaction-logs.index', ['user_id' => $log->user_id]) }}" class="btn btn-default">
                                            <i class="fa fa-user"></i> Logs de cet utilisateur
                                        </a>
                                    @endif

                                    <a href="{{ route('transaction-logs.index', ['model_type' => $log->model_type]) }}" class="btn btn-default">
                                        <i class="fa fa-filter"></i> Logs de ce type
                                    </a>

                                    <a href="{{ route('transaction-logs.index', ['action' => $log->action]) }}" class="btn btn-default">
                                        <i class="fa fa-tag"></i> Logs {{ $log->action }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques -->
                @if(isset($stats))
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <i class="fa fa-bar-chart"></i> Statistiques
                            </h4>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <h4 class="text-success">{{ $stats['total_logs'] ?? 0 }}</h4>
                                    <small>Total logs</small>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <h4 class="text-info">{{ $stats['logs_today'] ?? 0 }}</h4>
                                    <small>Aujourd'hui</small>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <small class="text-success">{{ $stats['creates'] ?? 0 }}</small>
                                    <br><small>Créations</small>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <small class="text-warning">{{ $stats['updates'] ?? 0 }}</small>
                                    <br><small>Modifications</small>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <small class="text-danger">{{ $stats['deletes'] ?? 0 }}</small>
                                    <br><small>Suppressions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .label-lg {
            font-size: 12px;
            padding: 4px 8px;
        }

        .pre-scrollable {
            max-height: 200px;
            overflow-y: scroll;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            font-size: 12px;
        }

        .list-group-item.active {
            background-color: #337ab7;
            border-color: #337ab7;
        }

        .btn-group-vertical .btn {
            margin-bottom: 5px;
        }

        .panel-title .badge {
            background-color: #777;
            font-size: 10px;
        }
    </style>

    <script>
        $(document).ready(function(){
            // Tooltip pour les valeurs tronquées
            $('[data-toggle="tooltip"]').tooltip();

            // Copier au clic sur les codes
            $('code').click(function(){
                var text = $(this).text();
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(text).then(function() {
                        // Feedback visuel
                        var original = $(this);
                        original.addClass('bg-success').fadeOut(100).fadeIn(100);
                        setTimeout(function(){
                            original.removeClass('bg-success');
                        }, 1000);
                    });
                }
            });

            // Navigation par clavier
            $(document).keydown(function(e) {
                @if($previousLog)
                if (e.keyCode == 37) { // Flèche gauche
                    window.location.href = "{{ route('transaction-logs.show', $previousLog->id) }}";
                }
                @endif
                    @if($nextLog)
                if (e.keyCode == 39) { // Flèche droite
                    window.location.href = "{{ route('transaction-logs.show', $nextLog->id) }}";
                }
                @endif
            });
        });
    </script>
@endsection
