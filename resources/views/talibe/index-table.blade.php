@extends('layouts.scratch',['title' => 'Liste des talibeList | '])
@push('styles')

@endpush

@section('content')

    <div class="container-fluid">
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
                                    <th>Serigne</th>
                                    <th>Daara</th>
                                    <th>Pere</th>
                                    <th>Mere</th>
                                    <th>Niveau</th>
                                    <th>Adresse</th>
                                    <th>Tuteur</th>
                                    <th class="text-right">Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Serigne</th>
                                    <th>Daara</th>
                                    <th>Pere</th>
                                    <th>Mere</th>
                                    <th>Niveau</th>
                                    <th>Adresse</th>
                                    <th>Tuteur</th>
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
                                                @if($enregistere['dieuw']!=null)
                                                    {{$enregistere['dieuw']}}
                                                @else
                                                    <span class="category badge badge-orange text-white">Non Affecté</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($enregistere['daara']!=null)
                                                    {{$enregistere['daara']}}
                                                @else
                                                    <span class="category badge badge-warning text-white">Non orienté</span>
                                                @endif
                                            </td>
                                            <td> {{ $enregistere['pere'] }} </td>
                                            <td> {{ $enregistere['mere'] }} </td>
                                            <td> {{ $enregistere['niveau'] }} </td>
                                            <td> {{ $enregistere['adresse'] }} </td>
                                            <td> {{ $enregistere['tuteur'] }} </td>
                                            <td> <span class="category badge badge-success text-white">Enregister</span> </td>
                                        </tr>
                                    @endforeach
                                    @endif

                                    @if(count(Session::get('rapport_dupliques'))>0)
                                        @foreach(Session::get('rapport_dupliques') as $duplique)
                                        <tr>
                                            <td>{{$duplique['numero']}}</td>
                                            <td>{{ ucfirst(strtolower($duplique['prenom']))}} <strong><b>{{ strtoupper($duplique['nom']) }}</b></strong></td>
                                            <td> {{ $duplique['dieuw'] }}</td>
                                            <td> {{$duplique['daara']}}</td>
                                            <td> {{ $duplique['pere'] }} </td>
                                            <td> {{ $duplique['mere'] }} </td>
                                            <td> {{ $duplique['niveau'] }} </td>
                                            <td> {{ $duplique['adresse'] }} </td>
                                            <td> {{ $duplique['tuteur'] }} </td>
                                            <td> <span class="category badge badge-warning text-white">Dupliquer</span> </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                    @if(count(Session::get('rapport_erreurs'))>0)
                                        @foreach(Session::get('rapport_erreurs') as $erreur)
                                        <tr>
                                            <td>{{$erreur['numero']}}</td>
                                            <td>{{ $erreur['prenom']}} <strong><b>{{ ($erreur['nom']) }}</b></strong></td>
                                            <td> {{ $erreur['dieuw'] }}</td>
                                            <td> {{$erreur['daara']}}</td>
                                            <td> {{ $erreur['pere'] }} </td>
                                            <td> {{ $erreur['mere'] }} </td>
                                            <td> {{ $erreur['niveau'] }} </td>
                                            <td> {{ $erreur['adresse'] }} </td>
                                            <td> {{ $erreur['tuteur'] }} </td>
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
                            <form method="POST" enctype="multipart/form-data" action="{{route('importation_talibe')}}">
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

        {{--Debut Liste des talibes--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="fas fa-user m-1" style="font-size: x-large"></i>
                        </div>
                        <h4 class="card-title mt-10" > Liste des Talibés: [{{ $nbr }}]</h4>
                        <p class="card-category" style="color: #000000">Cliquez sur le nom d'un talibé pour afficher plus de détails</p>
                        <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('talibe.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
                        <a class="btn btn-primary" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" data-toggle="modal" data-target="#myModal" href="#"><i class="fas fa-file"></i>Importer fichier excel</a>

                         @if(Session::has('rapport_enregistres') || Session::has('rapport_dupliques') || Session::has('rapport_erreurs'))
                            <button  class="btn btn-danger button_rapport" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px; margin-right: 10px;"><span id="eye"><i class="fas fa-eye"></i></span><span id="libelle">Voir rapport d'imporation</span></button>
                        @endif
{{--
                        <button id="button_rapport" class="btn btn-danger" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px; margin-right: 10px;"><i class="fas fa-eye-slash"></i><span id="libelle">Voir rapport d'imporation</span></button>
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
                                    <th><strong>N°</strong></th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Age</th>
                                    <th>Daara</th>
                                    <th>Dieuwrigne</th>
                                    <th>Téléphone</th>
                                    <th>Niveau</th>
                                    <th>Region</th>
                                    <th class="disabled-sorting text-right">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th><strong>N°</strong></th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Age</th>
                                    <th>Daara</th>
                                    <th>Dieuwrigne</th>
                                    <th>Téléphone</th>
                                    <th>Niveau</th>
                                    <th>Région</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($talibeList as $talibe)
                                    <tr>
                                        <td><span>{{$numero++}}</span></td>
                                        <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour voir les détails sur le Talibé">{{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></a></td>
                                        <td>
                                            @if( $talibe->age()!=null )
                                                {{ $talibe->age() }} ans
                                            @endif</td>
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
                                        <td> {{ $talibe->niveau }} </td>
                                        <td> {{ $talibe->region }} </td>
                                        <td class="text-right" style="font-size: 0.1em;">
                                            <a href="{{ route('talibe.show',['id' => $talibe->id]) }}" class="btn btn-link btn-info btn-just-icon" data-toggle="tooltip"  data-placement="left" title="Voir détails"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('talibe.edit',['id' => $talibe->id]) }}" class="btn btn-link btn-warning btn-just-icon"  data-toggle="tooltip"  data-placement="left" title="Modifier"><i class="fa fa-edit"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="row">
                                <div class="offset-md-6 col-md-6 col-sm-12">
                                    <p>{{ $talibeList->links() }}</p>
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
        {{--Fin liste des talibes--}}
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
            //type: type[color],
            timer: 3000,
            type: 'success',
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
                    searchPlaceholder: "Rechercher des Talibes",
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

   {{-- --}}{{--Tooltip--}}{{--
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>--}}

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
