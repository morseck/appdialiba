@extends('layouts.scratch', ['title' => 'Liste des Talibes de '.$dname.' |'])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h3 style="margin: auto;margin-bottom: 10px;"> Liste des Talibes de  {{ $dname }} : ({{ count($talibes) }})</h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title mt-10"> Liste des Talibés: [{{ $talibes->count() }}]</h4>
                        <p class="card-category" style="color: #000000">Cliquez sur le nom d'un talibé pour afficher plus de détails</p>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th><strong>n°</strong></th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Niveau</th>
                                    <th>Daara</th>
                                    <th>Téléphone</th>
                                    <th>Tuteur</th>
                                    <th>Adresse</th>
                                    <th class="text-right">Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Niveau</th>
                                    <th>Daara</th>
                                    <th>Téléphone</th>
                                    <th>Tuteur</th>
                                    <th>Adresse</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </tfoot>

                                <tbody>
                                <?php $i=1; ?>
                                  @foreach($talibes as $talibe)
                                      <tr>
                                          <td><strong><?php echo $i++;?></strong></td>
                                          <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour voir les détails sur le Talibé">{{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></a></td>
                                          <td><strong><b>{{ $talibe->niveau }}</b></strong></td>
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
                                              <a href="#" title="Cliquer pour envoyer un mail">{{ $talibe->phone1 }}</a>
                                          </td>
                                          <td> {{ $talibe->tuteur }} </td>
                                          <td> {{ $talibe->adresse }} </td>
                                          <td class="text-right" style="font-size: 0.1em;">
                                              <a href="{{ route('talibe.show',['id' => $talibe->id]) }}" class="btn btn-link btn-info btn-just-icon" data-toggle="tooltip"  data-placement="left" title="Voir détails"><i class="fa fa-eye"></i></a>
                                              <a href="{{ route('talibe.edit',['id' => $talibe->id]) }}" class="btn btn-link btn-warning btn-just-icon"  data-toggle="tooltip"  data-placement="left" title="Modifier"><i class="fa fa-edit"></i></a>
                                          </td>
                                      </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header card-header-info card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <h4 class="card-title mt-10"> Diagramme en zone polaire</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart1"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="card">
                            <div class="card-header card-header-success card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">pie_chart</i>
                                </div>
                                <h4 class="card-title mt-10"> Diagramme circulaire</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-12">
                         <div class="card">
                             <div class="card-header card-header-warning card-header-icon">
                                 <div class="card-icon">
                                     <i class="material-icons">insert_chart</i>
                                 </div>
                                 <h4 class="card-title mt-10"> Diagramme en barre</h4>
                             </div>
                             <div class="card-body">
                                 <canvas id="myChart3"></canvas>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{--Diagramme--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
        var talibes = 0;
        var myLabels = [] ;
        var myData =[] ;
        var myBackgroundColors =[] ;

        function randomColor()
        {
            var r=g=b=0;

            r = Math.floor((Math.random()* 254) ) ;
            g = Math.floor((Math.random()* 254) ) ;
            b = Math.floor((Math.random()* 254) ) ;

            return 'rgba('+r+','+g+','+b+',1)' ;
        }
    </script>
    <?php foreach ($parts as $key => $part) : ?>
    <script type="text/javascript">
        myLabels.push('<?= $part->niveau ?>') ;
        myData.push('{{ $part->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>
    {{--Omar--}}
    <script type="text/javascript">


        for(var i=0,l=myData.length; i < l ; i++ )
        {
            talibes += parseInt(myData[i]) ;
        }

        console.log(talibes);

        for(var i=0,l=myData.length; i < l ; i++ )
        {
            myLabels[i] += ' ('+ ((myData[i] / talibes ) * 100 ).toFixed(2) +' %)'+'  ['+myData[i]+']' ;
        }

        myData.push(0);
        var ctx1 = document.getElementById('myChart1');
        var ctx2 = document.getElementById('myChart2');
         var ctx3 = document.getElementById('myChart3');

        var data = {
            labels: myLabels,
            datasets: [{
                label: '# of Votes',
                data: myData,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;

        var myChart1 = new Chart(ctx1,{
            type: 'polarArea',
            data: data,
            options: {
                legend:{
                    display:false
                }
            }
        });

        var myChart2 = new Chart(ctx2,{
            type: 'doughnut',
            data: data,
            options: {

                legend:{
                    display:false
                }
            }
        });

         var myChart3 = new Chart(ctx3,{
             type: 'bar',
             data: data,
             options: {

                 legend:{
                     display:false
                 }
             }
         });

    </script>

    {{--DataTable--}}
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
                    searchPlaceholder: "Rechercher...",
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
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>


@endpush





