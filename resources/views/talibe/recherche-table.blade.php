@extends('layouts.scratch',['title' => 'Recherche Talibés | '])
@push('styles')

@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title mt-10"> Nombre de Talibés trouvés: [{{ $nombre }}] - requête [{{$recherche}}]</h4>
                        <p class="card-category" style="color: #000000">Cliquez sur le nom d'un talibé pour afficher plus de détails</p>
                       {{-- <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('talibe.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
                        <a class="btn btn-primary" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" data-toggle="modal" data-target="#myModal" href="#"><i class="fas fa-file"></i>Importer fichier excel</a>
                    --}}
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Daara</th>
                                    <th>Dieuwrigne</th>
                                    <th>Téléphone</th>
                                    <th>Tuteur</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Daara</th>
                                    <th>Dieuwrigne</th>
                                    <th>Téléphone</th>
                                    <th>Tuteur</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($talibeList as $talibe)
                                    <tr>
                                        <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour voir les détails sur le Talibé">{{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></a></td>

                                        <td>
                                            @if($talibe->daara != '' )
                                                <span class="success-badge bootstrap-tagsinput">
                                                    <span class="tag badge">
                                                        <a href="{{ route('by_daara',['id' => $talibe->daara->id]) }}" title="Cliquer pour voire les détails sur le Daara" class="text-white"><strong>{{$talibe->daara->nom}}</strong></a>
                                                    </span>
                                                </span>
                                            @else
                                                <span class="badge badge-pill badge-warning">non orienté</span>
                                            @endif

                                        </td>


                                        <td>
                                            @if($talibe->dieuw)
                                                <a href="{{ route('dieuw.show',['id' =>  $talibe->dieuw->id]) }}" title="Cliquer pour voire les détails sur le Dieuwrine" class="category badge badge-default text-white">{{ $talibe->dieuw->fullname() }}</a>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $talibe->phone1 }}
                                        </td>
                                        <td> {{ $talibe->tuteur }} </td>
                                        <td class="text-right">
                                            <a href="{{ route('talibe.show',['id' => $talibe->id]) }}" class="btn btn-link btn-info btn-just-icon" data-toggle="tooltip"  data-placement="left" title="Voir détails"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('talibe.edit',['id' => $talibe->id]) }}" class="btn btn-link btn-warning btn-just-icon"  data-toggle="tooltip"  data-placement="left" title="Modifier"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
    </div>
@endsection
@push('scripts')
    @if( session()->has('talibeEvent')  )

        <script type="text/javascript">
            (function(from, align) {
                type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                    icon: "notifications",
                    message: "{{ session('talibeEvent') }}"

                }, {
                    type: type[color],
                    timer: 3000,
                    placement: {
                        from: from,
                        align: align
                    }
                });
            })();

        </script>

    @endif

    <script>
        $(document).ready(function() {
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    //'copyHtml5',
                    'excelHtml5',
                    //'csvHtml5',
                    'pdfHtml5'
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });
            $('#importation').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: 'Bfrtip',
                buttons: [
                    //'copyHtml5',
                    'excelHtml5',
                    //'csvHtml5',
                    'pdfHtml5'
                ],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });

            var table = $('#datatable').DataTable();

            // Edit record
            table.on('click', '.edit', function() {
                $tr = $(this).closest('tr');
                var data = table.row($tr).data();
                alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
            });

            // Delete a record
            table.on('click', '.remove', function(e) {
                $tr = $(this).closest('tr');
                table.row($tr).remove().draw();
                e.preventDefault();
            });

            //Like record
            table.on('click', '.like', function() {
                alert('You clicked on Like button');
            });
        });
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
