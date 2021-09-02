@extends('layouts.scratch',['title' => 'liste consultations du médecin '.fullName($medecin->prenom, $medecin->nom)])
@push('styles')

@endpush

@section('content')

    <div class="container-fluid">
        {{--Debut Liste des  consultations--}}
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-user-md" style="font-size: x-large"></i>
                        </div>
                        <h4 class="card-title mt-10">
                            Détails des consultations du médecin <strong>{{ fullName($medecin->prenom, $medecin->nom) }}</strong>
                            <span class="badge badge-info"> {{ $medecin->spec }} - {{ $medecin->hopital }}</span> : [{{ $totalConsultations }}]
                        </h4>
                        <br>
                        <h6> <a href="{{ route('medecin.index') }}">Aller à la liste des médecins</a></h6>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th><strong>N°</strong></th>
                                    <th><strong>Talibes</strong></th>
                                    <th>Date Consultation</th>
                                    <th>Maladie</th>
                                    <th>Avis</th>
                                    <th>Lieu consultation</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><strong>N°</strong></th>
                                    <th><strong>Talibes</strong></th>
                                    <th>Date Consultation</th>
                                    <th>Maladie</th>
                                    <th>Lieu consultation</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($listeConsultations as $item)
                                    <tr>
                                        <td><span>{{$numero++}} </span></td>
                                        <td>
                                            <a href="{{ route('talibe.show',['id' => $item->talibe_id]) }}" title="Cliquez pour voir les détails sur le talibé"> <span style="color: black"><strong>{{ fullName($item->talibe_prenom,$item->talibe_nom)}}</strong></span></a>
                                            -
                                            <a href="{{ route('by_daara',['id' => $item->daara_id]) }}" title="Cliquez pour voir les détails sur le daaras"> <span class="category badge badge-pill badge-success " >{{$item->daara_nom}}</span></a>

                                        </td>
                                        <td>
                                            <a href="{{ route('consultation.show_consultation_by_date',['date' => $item->consultation_date]) }}" title="Cliquez pour voir les détails sur la campagne de conulatation">
                                                <span class="badge badge-default" style="font-size: small">{{ app_date_reverse($item->consultation_date, '-', '-') }}</span>
                                            </a>
                                        </td>
                                        <td>
                                            {{ $item->consultation_maladie }}
                                        </td>
                                        <td>
                                            {{ $item->consultation_avis }}
                                        </td>
                                        <td>
                                            {{ $item->consultation_lieu }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="offset-md-6 col-md-6 col-sm-12">
                                    <p>{{ $listeConsultations->links() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
    {{--Fin Liste des consultations--}}
    <!-- end row -->
    </div>


@endsection


@push('scripts')

    <script>
        $(document).ready(function() {
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "paging": false,
                "info": false,
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
                    searchPlaceholder: "Rechercher...",
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
                    searchPlaceholder: "Rechercher... ",
                    info: "Affichage de _START_ à _END_ sur _TOTAL_ entrée(s)"
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
