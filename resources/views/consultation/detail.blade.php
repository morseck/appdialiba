@extends('layouts.scratch',['title' => 'Details consultations | '.app_date_reverse($date, '-', '-')])
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
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title mt-10"> Détails de la journée de consultation du <span class="badge badge-info" style="font-size: medium"> {{app_date_reverse($date, '-', '-')}}</span>: [{{ $totalConsultations }}]</h4>
                        <h6 class="pull-right"> <a href="{{ route('consultation.index') }}">Aller à la liste des consultations</a></h6>
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
                                    <th>Médecin</th>
                                    <th>Maladie</th>
                                    <th>Avis</th>
                                    <th>Lieu consultation</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><strong>N°</strong></th>
                                    <th><strong>Talibes</strong></th>
                                    <th>Médecin</th>
                                    <th>Maladie</th>
                                    <th>Lieu consultation</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($listeConsultations as $item)
                                    <tr>
                                        <td><span>{{$numero++}} </span></td>
                                        <td>
                                            <a href="{{ route('talibe.show',['id' => $item->talibe_id]) }}" title="Cliquez pour voir les détails sur le talibé" class="btn btn-outline-success">
                                                <span style="">
                                                    <strong>{{ fullName($item->talibe_prenom,$item->talibe_nom)}}</strong>
                                                </span>
                                            </a>

                                            <span class="badge-white badge bootstrap-tagsinput">
                                                    <span class="tag">
                                                        <a href="{{ route('by_daara',['id' => $item->daara_id]) }}" title="Cliquez pour voir les détails sur le daaras">
                                                            <span  style="font-size: small">
                                                                <span class="btn btn-success category badge badge-pill " >{{$item->daara_nom}}</span>
                                                           </span>
                                                        </a>
                                                    </span>
                                                </span>
                                        </td>
                                        <td>
                                             <span class="badge-info badge bootstrap-tagsinput">
                                                 <span class="tag">
                                                    <a href="{{ route('medecin.show',['id' => $item->medecin_id]) }}" class="text-white">
                                                        <span style="font-size: small">
                                                            {{ fullName($item->medecin_prenom, $item->medecin_nom) }}
                                                        </span>
                                                    </a>
                                                </span>
                                             </span>
                                            <span class="category badge  badge-white" style="color: dimgrey">
                                                  {{ $item->medecin_specialiste.' - '.$item->medecin_hopital }}
                                            </span>
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
