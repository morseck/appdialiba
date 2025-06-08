@extends('layouts.scratch')

@section('title', 'Contenu du log - ' . $filename)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-alt"></i>
                            {{ $filename }}
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('logs.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Retour à la liste
                            </a>
                        </div>
                    </div>

                    <!-- Filtres -->
                    <div style="padding: 1rem; border-bottom: 1px solid #ddd;">
                        <form method="GET" action="{{ route('logs.show', $filename) }}" style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;">

                            <!-- Niveau de log -->
                            <div style="flex: 1 1 30%; min-width: 200px;">
                                <label for="level" style="display: block; margin-bottom: 0.3rem; font-weight: bold;">Niveau de log :</label>
                                <select name="level" id="level" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                                    <option value="all" {{ $level == 'all' ? 'selected' : '' }}>Tous les niveaux</option>
                                    @foreach(['emergency', 'alert', 'critical', 'error', 'warning', 'notice', 'info', 'debug'] as $lvl)
                                        <option value="{{ $lvl }}" {{ $level == $lvl ? 'selected' : '' }}>
                                            {{ ucfirst($lvl) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Recherche -->
                            <div style="flex: 1 1 50%; min-width: 250px;">
                                <label for="search" style="display: block; margin-bottom: 0.3rem; font-weight: bold;">Rechercher :</label>
                                <input type="text" name="search" id="search"
                                       value="{{ $search }}"
                                       placeholder="Rechercher dans les messages..."
                                       style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                            </div>

                            <!-- Bouton -->
                            <div style="flex: 1 1 15%; min-width: 150px;">
                                <label style="display: block; visibility: hidden;">Filtrer</label>
                                <button type="submit"
                                        style="width: 100%; padding: 0.6rem; background-color: #6f42c1; color: white; border: none; border-radius: 4px; cursor: pointer;">
                                    <i class="fas fa-filter"></i>
                                     Filtrer
                                </button>
                            </div>

                        </form>
                    </div>


                    <div class="card-body">
                        @if(empty($logs))
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Aucune entrée de log trouvée avec les critères spécifiés.
                            </div>
                        @else
                            <!-- Information sur les résultats -->
                            <div class="mb-3">
                                <small class="text-muted">
                                    Affichage de {{ count($logs) }} entrées sur {{ $pagination['total'] }} au total
                                    (Page {{ $pagination['current_page'] }} sur {{ $pagination['last_page'] }})
                                </small>
                            </div>

                            <!-- Pagination en haut -->
                            @if($pagination['last_page'] > 1)
                                <nav class="mb-3">
                                    <ul class="pagination pagination-sm">
                                        @if($pagination['current_page'] > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}">
                                                    Précédent
                                                </a>
                                            </li>
                                        @endif

                                        @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                                            <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if($pagination['current_page'] < $pagination['last_page'])
                                            <li class="page-item">
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}">
                                                    Suivant
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif

                            <!-- Logs -->
                            @foreach($logs as $index => $log)
                                <div class="log-entry mb-3 p-3 border rounded">
                                    <div class="log-header d-flex justify-content-between align-items-center mb-2">
                                        <div>
                                        <span class="badge badge-level-{{ strtolower($log['level']) }} mr-2">
                                            {{ strtoupper($log['level']) }}
                                        </span>
                                            <span class="text-muted">{{ $log['date'] }}</span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary" type="button"
                                                data-toggle="collapse" data-target="#log-{{ $index }}"
                                                aria-expanded="false">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>

                                    <div class="log-message">
                                        <strong>Message :</strong>
                                        <pre class="log-text">{{ $log['message'] }}</pre>
                                    </div>

                                    @if(!empty($log['context']) || !empty($log['stack_trace']))
                                        <div class="collapse" id="log-{{ $index }}">
                                            @if(!empty($log['context']))
                                                <div class="mt-3">
                                                    <strong>Contexte :</strong>
                                                    <pre class="log-text context">{{ trim($log['context']) }}</pre>
                                                </div>
                                            @endif

                                            @if(!empty($log['stack_trace']))
                                                <div class="mt-3">
                                                    <strong>Stack Trace :</strong>
                                                    <pre class="log-text stack-trace">{{ trim($log['stack_trace']) }}</pre>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <!-- Pagination en bas -->
                            @if($pagination['last_page'] > 1)
                                <nav class="mt-3">
                                    <ul class="pagination pagination-sm">
                                        @if($pagination['current_page'] > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] - 1]) }}">
                                                    Précédent
                                                </a>
                                            </li>
                                        @endif

                                        @for($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['last_page'], $pagination['current_page'] + 2); $i++)
                                            <li class="page-item {{ $i == $pagination['current_page'] ? 'active' : '' }}">
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if($pagination['current_page'] < $pagination['last_page'])
                                            <li class="page-item">
                                                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $pagination['current_page'] + 1]) }}">
                                                    Suivant
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .log-entry {
            background-color: #f8f9fa;
            border-left: 4px solid #dee2e6;
        }

        .log-text {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 10px;
            margin: 5px 0;
            font-size: 12px;
            white-space: pre-wrap;
            word-wrap: break-word;
            max-height: 200px;
            overflow-y: auto;
        }

        .log-text.context {
            background-color: #fff3cd;
            border-color: #ffeaa7;
        }

        .log-text.stack-trace {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .badge-level-emergency { background-color: #dc3545; }
        .badge-level-alert { background-color: #fd7e14; }
        .badge-level-critical { background-color: #dc3545; }
        .badge-level-error { background-color: #dc3545; }
        .badge-level-warning { background-color: #ffc107; color: #212529; }
        .badge-level-notice { background-color: #17a2b8; }
        .badge-level-info { background-color: #28a745; }
        .badge-level-debug { background-color: #6c757d; }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
        }

        .pagination-sm .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>

    <script>
        // Auto-submit form on filter change
        document.getElementById('level').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
@endsection
