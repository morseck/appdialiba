@extends('layouts.scratch',['title' => 'Création d\'un nouveau Médecin | '])


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
            <!--      Wizard container        -->
            <div class="wizard-container">
                <div class="card card-wizard" data-color="green" id="wizardProfile">
                    <form action="{{ route('medecin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf()
                    <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center">
                            <h4 class="card-title">Médecin N° {{ nb_medecins() + 1 }}</h4>
                            <h5 class="card-description">Création d'un nouveau Médecin.</h5>
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
                                                    <img src="../../assets/img/medecin-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
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
                                                    <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}" required>
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
                                                    <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
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
                                                        <option value="généraliste">Généraliste</option>
                                                        <option value="chirurgien">Chirurgien</option>
                                                        <option value="ophtalmologue">Ophtalmologue</option>
                                                        <option value="dentiste">Dentiste</option>
                                                        <option value="pédiatre">Pédiatre</option>
                                                        <option value="infirmier">Infirmier</option>
                                                        <option value="cardiologue">Cardiologue</option>
                                                        <option value="Sage-femme">Sage-femme</option>
                                                        <option value="délegue médical">Délégué médical</option>
                                                        <option value="étudiant">Etudiant</option>
                                                        <option value="autre">Autre</option>
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
                                                        <option value="fann">Fann</option>
                                                        <option value="principal">Principal</option>
                                                        <option value="dentheque">Dentheque</option>
                                                        <option value="Roi bedoin">Roi bedoin</option>
                                                        <option value="abass ndao">Abass ndao</option>
                                                        <option value="clinique les madelenes">Clinique les madelenes</option>
                                                        <option value="dalal diam">Dalal Diam</option>
                                                        <option value="hopital les maristes">Hopital les maristes</option>
                                                        <option value="hopital les grand yoff">Hopital Grand Yoff</option>
                                                        <option value="universite">Universite</option>
                                                        <option value="autre">Autre</option>
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
                                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
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
                                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}">
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
@endpush
