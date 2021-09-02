@extends('layouts.scratch',['title' => 'Liste des campagnes de consulatations | '])
@push('styles')

@endpush

@section('content')

    <div class="container-fluid">
        {{--Debut Liste des campagnes de consultations--}}
        <div class="row">
            <div class="col-md-8 col-sm-12 offset-md-2">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">grid_on</i>
                        </div>
                        <h4 class="card-title mt-10"> Liste des campagnes de consultation: [{{ $nombreCampagneConsultation }}]</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">
                        </div>
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th><strong>N°</strong></th>
                                    <th><strong>Date</strong></th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><strong>N°</strong></th>
                                    <th><strong>Date</strong></th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($consultations as $consulation)
                                    <tr>
                                        <td><span>{{$numero++}} </span></td>
                                        <td>
                                            <a href="{{ route('consultation.show_consultation_by_date',['date' => $consulation->date]) }}" title="Cliquez pour voir les détails sur la campagne de conulatation"> <span  class="category badge badge-pill badge-success " style="font-size: medium">{{ app_date_reverse($consulation->date, '-', '-') }}</span></a>
                                        </td>
                                        <td class="text-right">
                                            <a  href="{{ route('consultation.show_consultation_by_date',['date' => $consulation->date]) }}" class="btn btn-link btn-info btn-just-icon"  data-placement="left" title="Voir détails"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="offset-md-6 col-md-6 col-sm-12">
                                    <p>{{ $consultations->links() }}</p>
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
        {{--Fin Liste des campagnes de consultations--}}
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
