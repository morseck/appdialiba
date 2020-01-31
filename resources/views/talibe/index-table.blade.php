@extends('layouts.scratch',['title' => 'Liste des talibeList | '])
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
                        <h4 class="card-title mt-10"> Liste des Talibés</h4>
                        <p class="card-category" style="color: #000000">Cliquez sur le nom d'un talibé pour afficher plus de détails</p>
                        <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('talibe.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
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
                                        <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour plus de détails">{{ $talibe->prenom }} <strong>{{ $talibe->nom }}</strong></a></td>

                                        <td>{{ $talibe->daara != '' ? $talibe->daara->nom : 'non orienté'}}</td>


                                        <td>
                                            @if($talibe->dieuw)
                                                {{ $talibe->dieuw->fullname() }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" title="Cliquer pour envoyer un mail">{{ $talibe->phone1 }}</a>
                                        </td>
                                        <td> {{ $talibe->tuteur }} </td>
                                        <td class="text-right">
                                            <a href="#" class="btn btn-link btn-info btn-just-icon eyes"><i class="material-icons">favorite</i></a>
                                            <a href="#" class="btn btn-link btn-warning btn-just-icon pencil"><i class="material-icons">dvr</i></a>
                                            <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
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
        <!-- end row -->
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

@endpush
