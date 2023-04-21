@extends('layouts.scratch',['title' => 'Modifier d\'un ordonnance | '])

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


@push('styles')
    <style type="text/css">
        label{
            color: black !important;
        }
        .bootstrap-select>.dropdown-toggle{
            width: 114% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush


@section('content')
    <div class="container-fluid">
        <div class="col-md-8 col-12 mr-auto ml-auto">
            <div class="wizard-container">
                <div class="card card-wizard" data-color="green" id="wizardProfile">
                    <form action="{{ route('medecin.update',['id' => $medecin->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf()
                        {{ method_field('PUT')}}
                        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center">
                            <h4 class="card-title">medecin </h4>
                            <h5 class="card-description">Edition de profil.</h5>
                        </div>
                        @include('partials.errors')
                        <div class="wizard-navigation">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                                        Remplir les champs
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="about">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-6">
                                            <div class="picture-container">
                                                <div class="picture">
                                                    @if(($medecin->image !='') && ($medecin->image !='image medecin'))
                                                        <img src="{{ asset('myfiles/medecin/'.$medecin->image) }}" class="picture-src" id="wizardPicturePreview" title="" />
                                                    @else
                                                        <img src="{{ asset('assets/img/medecin-avatar.png') }}" class="picture-src" id="wizardPicturePreview" title="" />
                                                    @endif
                                                    <input type="file" id="wizard-picture" name="image">
                                                </div>
                                                <h6 class="category">Photo médecin</h6>
                                            </div>

                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                     <i class="fas fa-user"></i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInput1" class="bmd-label-floating">Prénom</label>
                                                    <input type="text" class="form-control" name="prenom" value="{{ old('prenom') ?? $medecin->prenom }}" required>
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fas fa-tag"></i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInput11" class="bmd-label-floating">Nom</label>
                                                    <input type="text" class="form-control" name="nom" value="{{ old('nom') ?? $medecin->nom }}"  required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-md"></i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <select class="selectpicker" data-style="select-with-transition" title="Spécialité" name="spec" required>
                                                        <option value="généraliste" {{ $medecin->spec == 'généraliste' ? 'selected' : ''}}>Généraliste</option>
                                                        <option value="chirurgien" {{ $medecin->spec == 'chirurgien' ? 'selected' : ''}}>Chirurgien</option>
                                                        <option value="ophtalmologue" {{ $medecin->spec == 'ophtalmologue' ? 'selected' : ''}}>Ophtalmologue</option>
                                                        <option value="dentiste" {{ $medecin->spec == 'dentiste' ? 'selected' : ''}}>Dentiste</option>
                                                        <option value="pédiatre" {{ $medecin->spec == 'pédiatre' ? 'selected' : ''}}>Pédiatre</option>
                                                        <option value="infirmier" {{ $medecin->spec == 'infirmier' ? 'selected' : ''}}>Infirmier</option>
                                                        <option value="cardiologue" {{ $medecin->spec == 'cardiologue' ? 'selected' : ''}}>Cardiologue</option>
                                                        <option value="Sage-femme" {{ $medecin->spec == 'Sage-femme' ? 'selected' : ''}}>Sage-femme</option>
                                                        <option value="délegue médical" {{ $medecin->spec == 'délegue médical' ? 'selected' : ''}}>Délégué médical</option>
                                                        <option value="étudiant" {{ $medecin->spec == 'étudiant' ? 'selected' : ''}}>Etudiant</option>
                                                        <option value="autre" {{ $medecin->spec == 'autre' ? 'selected' : ''}}>Autre</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                  <i class="fas fa-hospital"></i>
                                                </span>
                                                </div>
                                                <div class="form-group">
                                                    <select class="selectpicker" data-style="select-with-transition" title="Hôpital" name="hopital" required>
                                                        <option value="fann" {{ $medecin->hopital == 'fann' ? 'selected' : ''}}>Fann</option>
                                                        <option value="principal" {{ $medecin->hopital == 'principal' ? 'selected' : ''}}>Principal</option>
                                                        <option value="dentheque" {{ $medecin->hopital == 'dentheque' ? 'selected' : ''}}>Dentheque</option>
                                                        <option value="Roi bedoin"{{ $medecin->hopital == 'Roi bedoin' ? 'selected' : ''}}>Roi bedoin</option>
                                                        <option value="abass ndao" {{ $medecin->hopital == 'abass ndao' ? 'selected' : ''}}>Abass ndao</option>
                                                        <option value="clinique les madelenes" {{ $medecin->hopital == 'clinique les madelenes' ? 'selected' : ''}}>Clinique les madelenes</option>
                                                        <option value="dalal diam" {{ $medecin->hopital == 'dalal diam' ? 'selected' : ''}}>Dalal Diam</option>
                                                        <option value="hopital les maristes" {{ $medecin->hopital == 'hopital les maristes' ? 'selected' : ''}}>Hopital les maristes</option>
                                                        <option value="hopital les grand yoff" {{ $medecin->hopital == 'hopital les grand yoff' ? 'selected' : ''}}>Hopital Grand Yoff</option>
                                                        <option value="universite" {{ $medecin->hopital == 'universite' ? 'selected' : ''}}>Universite</option>
                                                        <option value="autre" {{ $medecin->hopital == 'autre' ? 'selected' : ''}}>Autre</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fas fa-phone"></i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInput11" class="bmd-label-floating">Télephone</label>
                                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') ?? $medecin->phone }}">
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInput11" class="bmd-label-floating">E-mail</label>
                                                    <input type="text" class="form-control" name="email" value="{{ old('email') ?? $medecin->email }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="ml-auto">
                                <input type="submit" class="btn btn-finish btn-fill btn-success btn-wd" name="finish" value="Valider" style="display: none;">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- wizard container -->
        </div>
    </div>
@endsection
@push('scripts-scroll')
    <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
@endpush

@push('scripts')
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
        });

        // Initialise the datepicker
        let dateOpt = {dateFormat: "d/m/Y", locale: 'fr'};

        $('#arrivee').flatpickr(dateOpt);
        $('#datenaissance').flatpickr(dateOpt);


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

@endpush
