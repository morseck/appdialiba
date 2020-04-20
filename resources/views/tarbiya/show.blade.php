@extends('layouts.scratch',['title' => 'Profil Ndongo Tarbiya de '.$tarbiya->fullname().' | '])

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-xs-12" style="margin: auto;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h4>Profil Ndongo Tarbiya</h4>
                                        <h3 class="card-title">{{ $tarbiya->fullname() }}</h3>
                                        @if( $tarbiya->age()!=null )
                                            <h4>{{ $tarbiya->age() }} ans</h4>
                                        @endif
                                        @if($tarbiya->daara != '' )
                                            <a href="{{ route('by_daara',['id' => $tarbiya->daara->id]) }}"><h4 class="category badge badge-success">{{ $tarbiya->daara != '' ? $tarbiya->daara->nom : 'non orienté' }}</h4></a>
                                            </span>
                                        @else
                                            <span class="category badge badge-warning">non orienté</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        @if(($tarbiya->avatar !='') && (($tarbiya->avatar !='image tarbiya') && $tarbiya->avatar !='user_male.ico') && $tarbiya->avatar !='user_female.ico')
                                            <img src="{{ asset('myfiles/tarbiya/'.$tarbiya->avatar) }}" style="width:100px; height: 100px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('assets/img/default-avatar.png') }}" style="width:100px; height: 100px; border-radius: 50%;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Genre</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ intval($tarbiya->genre) === 1 ? 'Masculin': 'Féminin' }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Père</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->pere }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Mère</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->mere }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Tuteur</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->tuteur }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Phone 1</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->phone1 }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Phone 2</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->phone2 }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Adresse</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->adresse }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Région</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->region }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Date de naissance</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ app_date_reverse($tarbiya->datenaissance,'-','-') }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Lieu de naissance</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ $tarbiya->lieunaissance }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-xs-6"><b>Date d'arrivée</b></div>
                                    <div class="col-lg-6 col-xs-6">{{ app_date_reverse($tarbiya->arrivee,'-','-') }}</div>
                                </div>
                                @if($tarbiya->depart)
                                    <div class="row">
                                        <div class="col-lg-4 col-xs-6"><b>Date de départ</b></div>
                                        <div class="col-lg-6 col-xs-6">{{ app_date_reverse($tarbiya->depart,'-','-') }}</div>
                                    </div>
                                @endif
                                @if($tarbiya->deces)
                                    <div class="row">
                                        <div class="col-lg-4 col-xs-6"><b>Date de décès</b></div>
                                        <div class="col-lg-6 col-xs-6">{{ app_date_reverse($tarbiya->deces,'-','-') }}</div>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a class="btn btn-info btn-sm" href="{{ route('tarbiya.edit',['id' => $tarbiya->id]) }}"><i class="fas fa-user-edit"></i> Editer</a>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletmodal"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <a class="btn btn-default btn-sm" href="{{ route('tarbiya.index') }}"><i class="fas fa-list"></i> Liste tarbiya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        Voulez-vous vraiment supprimer ce profil ?
                    </div>
                    <div class="modal-footer text-center">
                        <div class="row text-center">
                            <br>
                            <div class="col-lg-6">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            </div>
                            <div class="col-lg-6">
                                <form action="{{ route('tarbiya.destroy',['id' => $tarbiya->id ]) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--Notification--}}
@push('scripts')
    @if( session()->has('tarbiyaEvent')  )
        <script type="text/javascript">
            (function(from, align) {
                //type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                    icon: "notifications",
                    message: "{{ session('tarbiyaEvent') }}"

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
@endpush


