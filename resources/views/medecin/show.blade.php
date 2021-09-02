@extends('layouts.scratch',['title' => 'Profil de '.$medecin->fullname().' | '])


@section('content')

    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-lg-7 col-xs-8" style="margin: auto;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Profil Médecin</h5>
                                        <h3 class="card-title">{{ ucfirst(strtolower($medecin->prenom))}} <strong><b>{{ strtoupper($medecin->nom) }}</b></strong></h3>
                                        <a href="{{ route('consultation.show_consultation_by_medecin',['medecin_id' => $medecin->id]) }}" title="Cliquez pour voir les détails sur les consultations du médecin">
                                            <h6 class="badge badge-info">
                                                <b>Nombre total de consultations : </b>
                                                <strong>{{ $totalConsultation }}</strong>
                                            </h6>
                                        </a>
                                    </div>
                                    <div class="col-lg-6">
                                        @if(($medecin->image !='') && ($medecin->image !='image medecin'))
                                            <img src="{{ asset('myfiles/medecin/'.$medecin->image) }}" style="width:100px; height: 100px; border-radius: 50%;">
                                        @else
                                            <img src="{{ asset('assets/img/medecin-avatar.png') }}" style="width:100px; height: 100px; border-radius: 50%;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Hôpital</b></div>
                                    <div class="col-lg-6 col-xs-6"><b style="font-size: 1.4em"><strong>{{ $medecin->hopital }}</strong></b></div>
                                </div>
                                <hr>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Spécialité</b></div>
                                    <div class="col-lg-6 col-xs-6"><b style="font-size: 1.4em"><strong>{{ $medecin->spec }}</strong></b></div>
                                </div>
                                <hr>
                                <div class="row mbt-15">
                                    <div class="col-lg-4 col-xs-6"><b>Téléphone</b></div>
                                    <div class="col-lg-6 col-xs-6"><b style="font-size: 1.4em"><strong>{{ $medecin->phone }}</strong></b></div>
                                </div>
                                <br>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <a class="btn btn-info" href="{{ route('medecin.edit',['id' => $medecin->id]) }}"><i class="fas fa-user-edit"></i> Editer</a>
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletmodal"><i class="fas fa-trash-alt"></i> Supprimer</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <a class="btn btn-default" href="{{ route('medecin.index') }}"><i class="fas fa-list"></i> Liste Médecins</a>
                                    </div>
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
                            <form action="{{ route('medecin.destroy',['id' => $medecin->id ]) }}" method="post">
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
@endsection

@push('scripts')
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
@endpush


