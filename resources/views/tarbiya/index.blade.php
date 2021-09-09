@extends('layouts.scratch',['title' => 'Liste des Ndongos Tarbiya | '])

@section('content')
    <div class="container-fluid">
        {{--Debut titre--}}
        <div class="row">
            <h3 style="margin: auto;margin-bottom: 10px;"> Liste de tous les Ndongos Tarbiya : [{{ nb_tarbiyas() }}]</h3>
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
                                    <th>Daara</th>
                                    <th>Pere</th>
                                    <th>Mere</th>
                                    <th>Adresse</th>
                                    <th>Tuteur</th>
                                    <th class="text-right">Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>n°</th>
                                    <th>Prenom <strong>Nom</strong></th>
                                    <th>Daara</th>
                                    <th>Pere</th>
                                    <th>Mere</th>
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
                                                    @if($enregistere['daara']!=null)
                                                        {{$enregistere['daara']}}
                                                    @else
                                                        <span class="category badge badge-warning text-white">Non orienté</span>
                                                    @endif
                                                </td>
                                                <td> {{ $enregistere['pere'] }} </td>
                                                <td> {{ $enregistere['mere'] }} </td>
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
                                                <td> {{$duplique['daara']}}</td>
                                                <td> {{ $duplique['pere'] }} </td>
                                                <td> {{ $duplique['mere'] }} </td>
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
                                                <td> {{$erreur['daara']}}</td>
                                                <td> {{ $erreur['pere'] }} </td>
                                                <td> {{ $erreur['mere'] }} </td>
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
                            <form method="POST" enctype="multipart/form-data" action="{{route('importation_tarbiya')}}">
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

        {{--Debut Liste des ndongos tarbiya--}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon card-header-info">
                        <div class="card-icon">
                            <i class="fas fa-male m-1" style="font-size: x-large"></i>
                        </div>
                        <h4 class="card-title mt-10"> Liste des Ndongos tarbiya: [{{ nb_tarbiyas() }}]</h4>
                        <p class="card-category text-dark">Cliquez sur le nom d'un ndongo tarbiya pour afficher plus de détails</p>
                        <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('tarbiya.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
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
                                    <th>Age</th>
                                    <th>Daara</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tfoot class="text-primary">
                                <tr>
                                    <th>n°</th>
                                    <th>Prenom <b>NOM</b></th>
                                    <th>Age</th>
                                    <th>Daara</th>
                                    <th>Téléphone</th>
                                    <th>Adresse</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>

                                <tbody>
                                <?php $i=1; ?>
                                @foreach($tarbiyas as $tarbiya)
                                    <tr>
                                        <td><strong><?php echo $i++;?></strong></td>
                                        <td>
                                            <a href="{{ route('tarbiya.show',['id' => $tarbiya->id]) }}"
                                               title="Cliquez pour voir les détails sur le Ngongo Tarbiya"
                                               class="btn btn-outline-info"
                                            >
                                                <i class="mr-1 fas fa-male"></i>
                                                <strong><b>{{ fullName($tarbiya->prenom, $tarbiya->nom) }}</b></strong>
                                            </a>
                                        </td>
                                        <td>
                                            @if( $tarbiya->age()!=null )
                                                {{ $tarbiya->age() }} ans
                                            @endif
                                        </td>
                                        <td>
                                            @if($tarbiya->daara != '' )
                                                <span class="success-badge bootstrap-tagsinput">
                                                    <span class="tag badge">
                                                        <a href="{{ route('by_daara',['id' => $tarbiya->daara->id]) }}"
                                                           title="Cliquer pour voire les détails sur le Daara"
                                                           class="text-white"
                                                        >
                                                            <i class="mr-1 fas fa-home"></i>
                                                            {{$tarbiya->daara->nom}}
                                                        </a>
                                                    </span>
                                                </span>
                                            @else
                                                <span class="badge badge-pill badge-warning">non orienté</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#" title="Cliquer pour envoyer un mail">{{ $tarbiya->phone1 }}</a>
                                        </td>
                                        <td> {{ $tarbiya->adresse }} </td>
                                        <td>
                                            <a href="{{ route('tarbiya.show',['id' => $tarbiya->id]) }}" class="btn btn-link btn-info btn-just-icon" data-toggle="tooltip"  data-placement="left" title="Voir détails"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('tarbiya.edit',['id' => $tarbiya->id]) }}" class="btn btn-link btn-warning btn-just-icon"  data-toggle="tooltip"  data-placement="left" title="Modifier"><i class="fa fa-edit"></i></a>

                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{--     <div class="card-footer">
                             <p>{{ $tarbiyas->links() }}</p>
                         </div>--}}

                </div>
            </div>
        </div>
        {{--Fin Liste des tarbiyas--}}

    </div>
@endsection


@push('scripts')
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
    @if( session()->has('tarbiyaEvent')  )


        <script type="text/javascript">
            (function(from, align) {
                type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                    icon: "notifications",
                    message: "{{ session('tarbiyaEvent') }}"

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
