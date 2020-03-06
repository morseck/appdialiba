@extends('layouts.scratch',['title' => 'Liste des Dieuws | '])

@section('content')
         <div class="container-fluid">
         	<div class="row">
			<h3 style="margin: auto;margin-bottom: 10px;"> Liste de tous les dieuws : [{{ $nbr }}]</h3>
		 </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header card-header-icon card-header-success">
                    <div class="card-icon">
                      <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title mt-0"> Liste des Dieuwrigne</h4>
                    <p class="card-category">Cliquez sur le nom d'un dieuw pour afficher plus de détails</p>
                    <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('dieuw.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
                  </div>
                  <div class="card-body">
                      <div class="material-datatables">
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead class="text-primary">
                          <th>Nom</th>
                          <th>Daara</th>
                          <th>Téléphone</th>
                          <th>Tuteur</th>
                        </thead>

                        <tbody>
                          @foreach($dieuws as $dieuw)
                          <tr>
                            <td><a href="{{ route('dieuw.show',['id' => $dieuw->id]) }}" title="Cliquez pour plus de détails">{{ $dieuw->fullname() }}</a></td>
                            
                            <td>{{ $dieuw->daara != '' ? $dieuw->daara->nom : 'non orienté'}}</td>


                          
                            <td>
                              <a href="#" title="Cliquer pour envoyer un mail">{{ $dieuw->phone1 }}</a>
                            </td>
                            <td> {{ $dieuw->tuteur }} </td>
                          </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="card-footer">
                  	<p>{{ $dieuws->links() }}</p>
                  </div>

                </div>
              </div>          
            </div>
          </div>         
@endsection


@push('scripts')
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
        @if( session()->has('dieuwEvent')  )


          <script type="text/javascript">
            (function(from, align) {
            type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

            color = Math.floor((Math.random() * 6) + 1);

            $.notify({
                icon: "notifications",
                message: "{{ session('dieuwEvent') }}"

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
@endpush
