@extends('layouts.scratch', ['title' => 'Liste des Talibes du Daara '.$dname.' |'])

@section('content')
         <div class="container-fluid">
         	<div class="row">
			    <div class="card">
                    <div class="card-body ">
                        <span style="float: right">
                            <strong><i class="fas fa-user-graduate mr-1" ></i> <b>{{$daara_info['dieuw']}}</b>
                                @if($daara_info['telephone']!='neant' || $daara_info['telephone'])
                                    <span class="category badge badge-default text-white ml-3"><i class="fas fa-phone mr-1"></i> {{$daara_info['telephone']}}</span>
                                @endif
                            </strong>
                        </span>
                        <h3 style="margin: auto;margin-bottom: 10px;"> Détails Daara  <strong><b>{{ $dname }}</b></strong> </h3>
                    </div>
                </div>
		    </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title mt-10"> Liste des Talibés de {{$dname}}: [{{ $talibes->count() }}] </h4>
                                    <p class="card-category" style="color: #000000">Cliquez sur le nom d'un talibé pour afficher plus de détails</p>
                                </div>
                                <div class="card-body">
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Prenom <strong>Nom</strong></th>
                                                <th>Age</th>
                                                <th>Niveau</th>
                                                <th>Dieuwrigne</th>
                                                <th>Tuteur</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>Prenom <strong>Nom</strong></th>
                                                <th>Age</th>
                                                <th>Niveau</th>
                                                <th>Dieuwrigne</th>
                                                <th>Tuteur</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                            </tfoot>

                                            <tbody>
                                            @foreach($talibes as $talibe)
                                                <tr>
                                                    <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour voir les détails sur le Talibé">{{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></a></td>
                                                    <td>
                                                        @if( $talibe->age()!=null )
                                                            {{ $talibe->age() }} ans
                                                        @endif
                                                    </td>
                                                    <td>{{ $talibe->niveau }}</td>
                                                    <td>
                                                        @if($talibe->dieuw)
                                                            <a href="{{ route('dieuw.show',['id' =>  $talibe->dieuw->id]) }}" title="Cliquer pour voire les détails sur le Dieuwrine" class="category badge badge-default text-white">{{ $talibe->dieuw->fullname() }}</a>
                                                        @endif
                                                    </td>
                                                    <td> {{ $talibe->tuteur }} </td>
                                                    <td class="text-right">
                                                        <a href="{{ route('talibe.edit',['id' => $talibe->id]) }}"  data-toggle="tooltip"  data-placement="left" title="Modifier" style="font-size: 1.5em; color: #FF9800"><i class="fa fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header card-header-danger card-header-icon">
                                            <div class="card-icon">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <h4 class="card-title mt-10"> Liste des Serigne Daara de {{$dname}}: [{{ $dieuwrines->count() }}] </h4>
                                            <p class="card-category" style="color: #000000">Cliquez sur le nom d'un Serigne Daara pour afficher plus de détails</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="material-datatables">
                                                <table id="dieuwrigneDatatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Prenom <strong>Nom</strong></th>
                                                        <th>Age</th>
                                                        <th>Telephone</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Prenom <strong>Nom</strong></th>
                                                        <th>Age</th>
                                                        <th>Telephone</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                    </tfoot>

                                                    <tbody>
                                                    @foreach($dieuwrines as $dieuw)
                                                        <tr>
                                                            <td><a href="{{ route('dieuw.show',['id' => $dieuw->id]) }}" title="Cliquez pour voir les détails sur le Dieuwrine">{{ ucfirst(strtolower($dieuw->prenom))}} <strong><b>{{ strtoupper($dieuw->nom) }}</b></strong></a></td>
                                                            <td>
                                                                @if( $dieuw->age()!=null )
                                                                    {{ $dieuw->age() }} ans
                                                                @endif
                                                            </td>
                                                            <td>{{$dieuw->phone1}}</td>
                                                            <td class="text-right">
                                                                <a href="{{ route('dieuw.edit',['id' => $dieuw->id]) }}"  data-toggle="tooltip"  data-placement="left" title="Modifier" style="font-size: 1.5em; color: #FF9800"><i class="fa fa-edit"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header card-header-success card-header-icon">
                                            <div class="card-icon">
                                                <i class="fas fa-male"></i>
                                            </div>
                                            <h4 class="card-title mt-10"> Liste des Ndongos Tarbiya Daara de {{$dname}}: [{{ $tarbiyas->count() }}] </h4>
                                            <p class="card-category" style="color: #000000">Cliquez sur le n om d'un Serigne Daara pour afficher plus de détails</p>
                                        </div>
                                        <div class="card-body">
                                            <div class="material-datatables">
                                                <table id="datatableTarbiya" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th>Prenom <strong>Nom</strong></th>
                                                        <th>Age</th>
                                                        <th>Telephone</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th>Prenom <strong>Nom</strong></th>
                                                        <th>Age</th>
                                                        <th>Telephone</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                    </tfoot>

                                                    <tbody>
                                                    @foreach($tarbiyas as $tarbiya)
                                                        <tr>
                                                            <td><a href="{{ route('tarbiya.show',['id' => $tarbiya->id]) }}" title="Cliquez pour voir les détails sur le Ndongo Tarbiya">{{ ucfirst(strtolower($tarbiya->prenom))}} <strong><b>{{ strtoupper($tarbiya->nom) }}</b></strong></a></td>
                                                            <td>
                                                                @if( $tarbiya->age()!=null )
                                                                    {{ $tarbiya->age() }} ans
                                                                @endif
                                                            </td>
                                                            <td>{{$tarbiya->phone1}}</td>
                                                            <td class="text-right">
                                                                <a href="{{ route('tarbiya.edit',['id' => $tarbiya->id]) }}"  data-toggle="tooltip"  data-placement="left" title="Modifier" style="font-size: 1.5em; color: #FF9800"><i class="fa fa-edit"></i></a>
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
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">insert_chart</i>
                                    </div>
                                    <h4 class="card-title mt-10"> Diagramme en barre horitazontale des talibes de {{$dname}} en fonction des hizibs</h4>
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
                                    <h4 class="card-title mt-10"> Diagramme en circulaire des <b>régions</b> en fonction des talbés de {{$dname}} </h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart2"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">insert_chart</i>
                                    </div>
                                    <h4 class="card-title mt-10"> Diagramme en barre horitazontale des <b>Serignes daara</b> de {{$dname}} en fonction des talibes</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart3"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card" >
                                <div class="card-header card-header-icon card-header-danger">
                                    <div class="card-icon">
                                        <i class="material-icons">insert_chart</i>
                                    </div>
                                    <h4 class="card-title">Répartition des <b>Maladies</b> en fonction de leur apparution
                                        <!-- <small> - Rounded</small> -->
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="myChart4"></canvas>
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

        var dieuws = 0;
        var myLabelDieuws = [] ;
        var myDataDieuws =[] ;

        var regions = 0;
        var myLabelRegions = [] ;
        var myDataRegions =[] ;

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

    <?php foreach ($partDieuws as $key => $p) : ?>
    <script type="text/javascript">
        myLabelDieuws.push('<?= $p->fullname ?>') ;
        myDataDieuws.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partRegions as $key => $p) : ?>
    <script type="text/javascript">
        myLabelRegions.push('<?= $p->region ?>') ;
        myDataRegions.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    {{--Omar--}}
    <script type="text/javascript">
        for(var i=0,l=myData.length; i < l ; i++ ) {
            talibes += parseInt(myData[i]) ;
        }

        for(var i=0,l=myDataDieuws.length; i < l ; i++ ) {
           // console.log(myDataDieuws[i]);
            dieuws += parseInt(myDataDieuws[i]) ;
        }

        for(var i=0,l=myDataRegions.length; i < l ; i++ ) {
            // console.log(myDataDieuws[i]);
            regions += parseInt(myDataRegions[i]) ;
        }

        console.log('talibes: '+talibes);
        console.log('Dieuwrines: '+dieuws);
        console.log('Region: '+regions);

        for(var i=0,l=myData.length; i < l ; i++ )
        {
            myLabels[i] += ' ('+ ((myData[i] / talibes ) * 100 ).toFixed(2) +' %)'+'  ['+myData[i]+']' ;
        }

        for(var i=0,l=myDataDieuws.length; i < l ; i++ )
        {
            myLabelDieuws[i] += ' ('+ ((myDataDieuws[i] / dieuws ) * 100 ).toFixed(2) +' %)'+'  ['+myDataDieuws[i]+']' ;
        }

        for(var i=0,l=myDataRegions.length; i < l ; i++ )
        {
            myLabelRegions[i] += ' ('+ ((myDataRegions[i] / regions ) * 100 ).toFixed(2) +' %)'+'  ['+myDataRegions[i]+']' ;
        }

        myData.push(0);
        myDataDieuws.push(0);
        myDataRegions.push(0);
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
        var dataDieuw = {
            labels: myLabelDieuws,
            datasets: [{
                label: '# of Votes',
                data: myDataDieuws,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;
        var dataRegion = {
            labels: myLabelRegions,
            datasets: [{
                label: '# of Votes',
                data: myDataRegions,
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
            type: 'horizontalBar',
            data: data,
            options: {
                legend:{
                    display:false
                }
            }
        });

        var myChart2 = new Chart(ctx2,{
            type: 'doughnut',
            data: dataRegion,
            options: {

                legend:{
                    display:false
                }
            }
        });

        var myChart3 = new Chart(ctx3,{
            type: 'horizontalBar',
            data: dataDieuw,
            options: {

                legend:{
                    display:false
                }
            }
        });

    </script>

    {{--Debut Diagramme Maladies --}}
    <script>
        //Definition des variables globales
        var maladies = 0;
        var myLabelmaladies= [] ;
        var myDatamaladies =[] ;
    </script>

    <?php foreach ($partMaladies as $key => $p) : ?>
    <script type="text/javascript">
        myLabelmaladies.push('<?= $p->maladie ?>') ;
        myDatamaladies.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <script>
        for(var i=0,l=myDatamaladies.length; i < l ; i++ ) {
            maladies += parseInt(myDatamaladies[i]) ;
        }

        console.log('maladies: '+maladies);

        for(var i=0,l=myDatamaladies.length; i < l ; i++ )
        {
            myLabelmaladies[i] += ' ('+ ((myDatamaladies[i] / maladies ) * 100 ).toFixed(2) +' %)'+'  ['+myDatamaladies[i]+']' ;
        }


        myDatamaladies.push(0);

        var ctx4 = document.getElementById('myChart4');
        var dataMaladie = {
            labels: myLabelmaladies,
            datasets: [{
                label: '#Maladies',
                data: myDatamaladies,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;


        var myChart4 = new Chart(ctx4,{
            type: 'bar',
            data: dataMaladie,
            options: {
                legend:{
                    display:true
                }
            }
        });
    </script>
    {{--Fin Diagramme Maladies --}}

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
                    searchPlaceholder: "Search records",
                }
            });
            $('#dieuwrigneDatatable').DataTable({
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

            var table = $('#datatableTarbiya').DataTable();

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
    {{--<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>--}}


@endpush





