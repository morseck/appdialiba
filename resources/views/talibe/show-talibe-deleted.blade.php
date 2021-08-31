@extends('layouts.scratch',['title' => 'Profil de '.$talibe->fullname().' | '])


@push('styles')
    <style type="text/css">
        div b {
            font-size: 1.1em;
        }

        .mbt-15 {
            margin-bottom: 7px;
        }

    </style>
@endpush

@section('content')

    <div class="container-fluid">
        {{--Debut bulletin de santé --}}
        <div class="row" id="bulletin_medical" style="display: none;">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            {{--<i class="material-icons">assignment</i>--}}
                            <i class="fas fa-ambulance"></i>
                        </div>
                        <h4 class="card-title mt-10" id="bulletin_medical"> Bulletin médical de {{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></h4>
                        <button class="btn btn-just-icon btn-round btn-reddit button_rapport" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px; margin-right: 10px;" data-toggle="tooltip"  data-placement="left" title="Fermer le rapport d'importation"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>n°</th>
                                    <th>Date </th>
                                    <th>Lieu</th>
                                    <th>Maladie</th>
                                    <th>Avis</th>
                                    <th>Médecin</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Date </th>
                                    <th>Lieu</th>
                                    <th>Maladie</th>
                                    <th>Avis</th>
                                    <th>Médecin</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php $i = 1; ?>
                                @foreach($consultations  as $consulta)
                                    <tr>
                                        <td><?php echo $i;?></td>
                                        <td>{{ app_date_reverse($consulta->date,'-','-') }}</td>
                                        <td>{{$consulta->lieu}}</td>
                                        <td>{{$consulta->maladie}}</td>
                                        <td> {{ $consulta->avis }} </td>
                                        <td>
                                            <a href="{{route('medecin.show', ['id' => $consulta->medecin->id])}}" class="category badge badge-success text-white">
                                                <span >{{$consulta->medecin->fullname()}}</span>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="card-header card-header-icon card-header-warning">
                            <div class="card-icon">
                                <i class="material-icons">insert_chart</i>
                            </div>
                            <h4 class="card-title">Répartition des <b>Maladies</b> en fonction de leur apparution
                                <!-- <small> - Rounded</small> -->
                            </h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-md-12 -->

        </div>
        {{--Fin bulletin de sante--}}

        {{--Debut show talibe--}}

        <div class="row">

            <div class="col-lg-7 col-xs-8">
                @include('partials.errors')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <h5 class="badge badge-danger" style="font-size: medium">Profil Talibé supprimé <i class="fa fa-trash"></i></h5>
                                        <h3 class="card-title">{{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></h3>
                                        @if( $talibe->age()!=null )
                                            <h3><strong>{{ $talibe->age() }} </strong> ans</h3>
                                        @endif
                                        @if($talibe->daara != '' )
                                            <a href="{{ route('by_daara',['id' => $talibe->daara->id]) }}" title="Cliquer pour voire les détails sur le Daara" >
                                                <h4 class="category badge badge-success">{{ $talibe->daara->nom  }}</h4>
                                            </a>
                                        @else
                                            <span class="category badge badge-warning">non orienté</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="text-center">
                                                    <button type="button" class="btn btn-round btn-outline-info button_rapport"><i class="fas fa-stethoscope"></i> <span id="libelle">Voir bulletin médical</span></button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Genre</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ intval($talibe->genre) === 1 ? 'Masculin': 'Féminin' }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Niveau d'étude</b></div>
                                    <div class="col-lg-6 col-xs-6"><strong><b>{{ $talibe->niveau }}</b></strong></div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Dieuwrigne</b></div>
                                    <div class="col-lg-6 col-xs-6">
                                        @if($talibe->dieuw != '')
                                            <a href="{{ route('dieuw.show',['id' =>  $talibe->dieuw->id]) }}" title="Cliquer pour voire les détails sur le Dieuwrine" class="category badge badge-default text-white">{{ $talibe->dieuw->fullname() }}</a>
                                        @else
                                            <span class="category badge badge-danger">non affecté</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Père</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->pere }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Mère</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->mere }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Tuteur</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->tuteur }}</div>
                                </div>

                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Phone 1</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->phone1 }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Phone 2</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->phone2 }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Adresse</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->adresse }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Région</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->region }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Date de naissance</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ app_date_reverse($talibe->datenaissance,'-','-') }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Lieu de naissance</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $talibe->lieunaissance }}</div>
                                </div>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Date d'arrivée</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ app_date_reverse($talibe->arrivee,'-','-') }}</div>
                                </div>
                                @if($talibe->depart)
                                    <div class="row mbt-15">
                                        <div class="col-lg-4 col-xs-6"><b>Date de départ</b></div>
                                        <div class="col-lg-6 col-xs-6">{{ $talibe->depart }}</div>
                                    </div>
                                @endif
                                @if($talibe->depart)
                                    <div class="row mbt-15">
                                        <div class="col-lg-4 col-xs-6"><b>Date de décès</b></div>
                                        <div class="col-lg-6 col-xs-6">{{ $talibe->deces }}</div>
                                    </div>
                                @endif
                                <br>
                            <!--  <div class="row">
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->commentaire }}</div>
				             </div><br> -->
                            </div>
                            <div class="card-footer">
                                <div class="row">

                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deletmodal"><i class="fas fa-reply"></i> Restaurer</button>
                                    </div>
                                    <div class="col-lg-4 offset-1">
                                        <a class="btn btn-default" href="{{ route('talibe.deleted') }}"><i class="fas fa-list"></i> Liste Talibés supprimés</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-xs-8" >
                <div class="card">
                    <div class="card-header text-center">
                        <p>
                            @if(($talibe->avatar !='') && (($talibe->avatar !='image talibe') && $talibe->avatar !='user_male.ico') && $talibe->avatar !='user_female.ico')
                                <img src="{{ asset('myfiles/talibe/'.$talibe->avatar) }}" style="width:100%; height: 100%">
                            @else
                                <img src="{{ asset('assets/img/default-avatar.png') }}" style="width:50%;">
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{--Fin show talibe--}}
    </div>

    <!-- deletion confirmation modal -->
    <div class="modal fade" id="deletmodal" tabindex="-1" role="dialog" aria-labelledby="deletmodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletmodalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Voulez-vous vraiment restaurer ce talibé?
                </div>
                <div class="modal-footer text-center">
                    <div class="row text-center">
                        <br>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-lg-6">
                            <form action="{{ route('talibe.restore',['id' => $talibe->id ]) }}" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-warning">Restaurer</button>
                            </form>
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

    {{--Debut datepicker--}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            //init DateTimePickers
            md.initFormExtendedDatetimepickers();

            // Initialise the wizard
            demo.initMaterialWizard();
            setTimeout(function() {
                $('.card.card-wizard').addClass('active');
            }, 200);

            // Initialise the datepicker
            let dateOpt = {dateFormat: "d/m/Y", locale: 'fr'};
            $('#date').flatpickr(dateOpt);

        });


        //    $('#input-file').change(function(event) {

        //      var fileList = event.target.files;

        //      console.log(fileList);

        //    if (fileList.length) {
        //      $('#filename').text(fileList[0].name)
        //    }
        // });
    </script>
    {{--Fin datepicker--}}


    {{--Debut dataTable--}}
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
    {{--Fin dataTable--}}

    {{-- Debut Affichage bulletin de sante--}}
    <script>
        $(function () {
            var libelle = $('#libelle').html();
            console.log(libelle);
            $('.button_rapport').click(function () {
                $('#bulletin_medical').slideToggle();
                if (libelle == "Voir bulletin médical"){
                    libelle = "Fermer bulletin médical";
                }else {
                    if (libelle == "Fermer bulletin médical"){
                        libelle = "Voir bulletin médical";
                    }
                }

                $('#libelle').html(libelle);
                //console.log("test");
            });
        });
    </script>
    {{-- Fin Affichage bulletin de sante--}}


    {{--Debut Diagramme Maladies --}}

    <script>
        var myBackgroundColors =[] ;

        function randomColor()
        {
            var r=g=b=0;

            r = Math.floor((Math.random()* 254) ) ;
            g = Math.floor((Math.random()* 254) ) ;
            b = Math.floor((Math.random()* 254) ) ;

            return 'rgba('+r+','+g+','+b+',1)' ;
        }

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

        var ctx1 = document.getElementById('myChart1');
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


        var myChart1 = new Chart(ctx1,{
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
@endpush



