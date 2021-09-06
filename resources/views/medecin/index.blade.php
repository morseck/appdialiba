@extends('layouts.scratch',['title' => 'Liste des Médecins | '])

@section('content')
    <div class="container-fluid">
        {{--Debut titre--}}
        <div class="row">
            <h3 style="margin: auto;margin-bottom: 10px;"> Liste de tous les Médecins : [{{ $nbr }}]</h3>
        </div>
        {{--Fin titre--}}

        {{--Debut Rapport importation --}}
        <div class="row" id="rapport_importation" style="display: none  ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title mt-10" id="rapport_importation"> Rapport d'importation</h4>
                        <button class="btn btn-just-icon btn-round btn-reddit button_rapport" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px; margin-right: 10px;" data-toggle="tooltip"  data-placement="left" title="Fermer le rapport d'importation"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="importation" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                <tr>
                                    <th>n°</th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Specilite</th>
                                    <th>Telephone</th>
                                    <th>Hopital</th>
                                    <th>Email</th>
                                    <th class="text-right">Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Specilite</th>
                                    <th>Telephone</th>
                                    <th>Hopital</th>
                                    <th>Email</th>
                                    <th class="text-right">Status</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @if(Session::has('rapport_enregistres') || Session::has('rapport_dupliques') || Session::has('rapport_erreur'))
                                    @if(count(Session::get('rapport_enregistres'))>0)
                                        @foreach(Session::get('rapport_enregistres')  as $enregistere)
                                            <tr>
                                                <td>{{$enregistere['numero']}}</td>
                                                <td>{{ ucfirst(strtolower($enregistere['prenom']))}} <strong><b>{{ strtoupper($enregistere['nom']) }}</b></strong></td>
                                                <td>
                                                    @if($enregistere['spec']!=null)
                                                        {{$enregistere['spec']}}
                                                    @else
                                                        <span class="category badge badge-warning text-white">Pas de spécialité</span>
                                                    @endif
                                                </td>
                                                <td> {{ $enregistere['phone'] }} </td>
                                                <td> {{ $enregistere['hopital'] }} </td>
                                                <td> {{ $enregistere['email'] }} </td>
                                                <td> <span class="category badge badge-success text-white">Enregister</span> </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                    @if(count(Session::get('rapport_dupliques'))>0)
                                        @foreach(Session::get('rapport_dupliques') as $duplique)
                                            <tr>
                                                <td>{{$duplique['numero']}}</td>
                                                <td>{{ ucfirst(strtolower($duplique['prenom']))}} <strong><b>{{ strtoupper($duplique['nom']) }}</b></strong></td>
                                                <td> {{$duplique['spec']}}</td>
                                                <td> {{ $duplique['phone'] }} </td>
                                                <td> {{ $duplique['hopital'] }} </td>
                                                <td> {{ $duplique['email'] }} </td>
                                                <td> <span class="category badge badge-warning text-white">Dupliquer</span> </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    @if(count(Session::get('rapport_erreurs'))>0)
                                        @foreach(Session::get('rapport_erreurs') as $erreur)
                                            <tr>
                                                <td>{{$erreur['numero']}}</td>
                                                <td>{{ $erreur['prenom']}} <strong><b>{{ ($erreur['nom']) }}</b></strong></td>
                                                <td> {{$erreur['spec']}}</td>
                                                <td> {{ $erreur['phone'] }} </td>
                                                <td> {{ $erreur['hopital'] }} </td>
                                                <td> {{ $erreur['email'] }} </td>
                                                <td> <span class="category badge badge-danger text-white">Erreur</span> </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-md-12 -->
        </div>
        {{--Fin Rapport importation--}}

        {{--Debut modal formulaire d'importation--}}
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- Classic Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Choisir un fichier excel</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    <i class="material-icons">clear</i>
                                </button>
                            </div>
                            <form method="POST" enctype="multipart/form-data" action="{{route('importation_medecin')}}">
                                <div class="modal-body">
                                    @csrf()
                                    <input type="file" class="form-control" name="importation_excel">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-link">valider <i class="material-icons">done</i></button>
                                    <button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close <i class="material-icons">close</i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--Fin modal formulaire d'importation--}}

        {{--Debut Liste des medecinrines--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-default">
                        <div class="card-icon">
                            <i class="fas fa-user-md m-1" style="font-size: x-large"></i>
                        </div>
                        <h4 class="card-title mt-10"> Liste des Médecin [{{ $nbr }}]</h4>
                        <p class="card-category text-dark">Cliquez sur le nom d'un Médecin pour afficher plus de détails</p>
                        <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('medecin.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
                        <a class="btn btn-primary" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" data-toggle="modal" data-target="#myModal" href="#"><i class="fas fa-file"></i>Importer fichier excel</a>

                        @if(Session::has('rapport_enregistres') || Session::has('rapport_dupliques') || Session::has('rapport_erreurs'))
                            <button  class="btn btn-danger button_rapport" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px; margin-right: 10px;"><span id="eye"><i class="fas fa-eye"></i></span><span id="libelle">Voir rapport d'imporation</span></button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead class="text-primary">
                                    <tr>
                                    <th>n°</th>
                                    <th>Prenom <b>NOM</b></th>
                                    <th>Specilite</th>
                                    <th>Telephone</th>
                                    <th>Hopital</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot class="text-primary">
                                    <tr>
                                    <th>n°</th>
                                    <th>Prenom <b>NOM</b></th>
                                    <th>Specilite</th>
                                    <th>Telephone</th>
                                    <th>Hopital</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    <?php $i=1; ?>
                                    @foreach($medecins as $medecin)
                                        <tr>
                                            <td><strong><?php echo $i++;?></strong></td>
                                            <td><a href="{{ route('medecin.show',['id' => $medecin->id]) }}" title="Cliquez pour voir les détails sur le Médecin">{{ ucfirst(strtolower($medecin->prenom))}} <strong><b>{{ strtoupper($medecin->nom) }}</b></strong></a></td>
                                            <td>
                                                @if($medecin->spec != '' )
                                                    {{$medecin->spec}}
                                                @else
                                                    <span class="badge badge-pill badge-warning">Pas de spécialité</span>
                                                @endif
                                            </td>
                                            <td>
                                               {{ $medecin->phone }}
                                            </td>
                                            <td> {{ $medecin->hopital }} </td>
                                            <td>
                                                <a href="{{ route('medecin.show',['id' => $medecin->id]) }}" class="btn btn-link btn-info btn-just-icon" data-toggle="tooltip"  data-placement="left" title="Voir détails"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('medecin.edit',['id' => $medecin->id]) }}" class="btn btn-link btn-warning btn-just-icon"  data-toggle="tooltip"  data-placement="left" title="Modifier"><i class="fa fa-edit"></i></a>

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
        {{--Fin Liste des medecinrines--}}

        {{--Debut diagramme--}}
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-danger">
                        <div class="card-icon">
                            <i class="material-icons">insert_chart</i>
                        </div>
                        <h4 class="card-title">Répartition des <b>Médecins</b> en fonctions de leur nombre de consultations
                        </h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart7"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{--Fin diagramme--}}
    </div>
@endsection


@push('scripts-scroll')
    <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
@endpush

@push('scripts')
    {{--Debut diagramme--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
        var medecins = 0;
        var myLabelmedecins= [] ;
        var myDatamedecins =[] ;

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

    <?php foreach ($diagramemeMedecin as $key => $p) : ?>
    <script type="text/javascript">
        myLabelmedecins.push('<?= fullName($p->medecin_prenom, $p->medecin_nom) .' | '.  $p->medecin_hopital?>') ;
        myDatamedecins.push('{{ $p->medecin_total }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <script>
        for(var i=0,l=myDatamedecins.length; i < l ; i++ ) {
            medecins += parseInt(myDatamedecins[i]) ;
        }

        for(var i=0,l=myDatamedecins.length; i < l ; i++ )
        {
            myLabelmedecins[i] += ' ('+ ((myDatamedecins[i] / medecins ) * 100 ).toFixed(2) +' %)'+'  ['+myDatamedecins[i]+']' ;
        }

        myDatamedecins.push(0);

        var ctx7 = document.getElementById('myChart7');

        var dataMedecin = {
            labels: myLabelmedecins,
            datasets: [{
                label: '#Medecins',
                data: myDatamedecins,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;

        var myChart7 = new Chart(ctx7,{
            type: 'bar',
            data: dataMedecin,
            options: {
                legend:{
                    display:false
                }
            }
        });

    </script>
    {{--Fin diagramme--}}




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
    @if( session()->has('medecinEvent')  )
        <script type="text/javascript">
            (function(from, align) {
                //type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                    icon: "notifications",
                    message: "{{ session('medecinEvent') }}"

                }, {
                    //type: type[color],
                    type: 'success',
                    timer: 3000,
                    placement: {
                        from: from,
                        align: align
                    }
                });
            })();

        </script>

    @endif

    {{--Affichage rapport d'importation--}}
    <script>
        $(function () {
            var libelle = $('#libelle').html();
            console.log(libelle);
            $('.button_rapport').click(function () {
                $('#rapport_importation').slideToggle();
                if (libelle == "Voir rapport d'imporation"){
                    libelle = "Fermer rapport d'importation";
                    $('#eye').html('<i class="fas fa-eye-slash"></i>')
                }else {
                    if (libelle == "Fermer rapport d'importation"){
                        libelle = "Voir rapport d'imporation";
                        $('#eye').html('<i class="fas fa-eye"></i>')
                    }
                }


                $('#libelle').html(libelle);
                //console.log("test");
            });
        });
    </script>
    @if( session()->has('message_enregistrer')  )

        <script type="text/javascript">
            (function(from, align) {

                $.notify({
                    icon: "check",
                    message: "{{ session('message_enregistrer') }}"

                }, {
                    type: 'success',
                    timer: 3000,
                    placement: {
                        from: from,
                        align: align
                    }
                });
            })();

        </script>

    @endif
    @if( session()->has('message_dupliquer')  )

        <script type="text/javascript">
            (function(from, align) {

                $.notify({
                    icon: "warning",
                    message: "{{ session('message_dupliquer') }}"

                }, {
                    type: 'warning',
                    timer: 3000,
                    placement: {
                        from: from,
                        align: align
                    }
                });
            })();

        </script>

    @endif
    @if( session()->has('message_erreur')  )

        <script type="text/javascript">
            (function(from, align) {

                $.notify({
                    icon: "stop",
                    message: "{{ session('message_erreur') }}"

                }, {
                    type: 'danger',
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
