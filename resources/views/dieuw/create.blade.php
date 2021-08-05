@extends('layouts.scratch',['title' => 'Création d\'un nouveau Dieuwrine | '])

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
                <form action="{{ route('dieuw.store') }}" method="POST" enctype="multipart/form-data">
                	@csrf()
                  <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                  <div class="card-header text-center">
                    <h4 class="card-title">Dieuwrine N° {{ nb_dieuws() + 1 }}</h4>
                    <h5 class="card-description">Création d'un nouveau Dieuwrine.</h5>
                  </div>
                  @include('partials.errors')
                  <div class="wizard-navigation">
                    <ul class="nav nav-pills">
                      <li class="nav-item">
                        <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                          Etape 1
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#account" data-toggle="tab" role="tab">
                          Etape 2
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#address" data-toggle="tab" role="tab">
                          Etape 3
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
                                <img src="../../assets/img/default-avatar.png" class="picture-src" id="wizardPicturePreview" title="" />
                                <input type="file" id="wizard-picture" name="avatar">
                              </div>
                              <h6 class="category">avatar</h6>
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
                                  <i class="fas fa-tags"></i>
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
                                  <i class="fas fa-venus-mars"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                 <select class="selectpicker" data-style="select-with-transition" title="Sexe" name="genre" required>
                                    <option value="1"><i class="fas fa-male"></i> Homme</option>
                                    <option value="0"><i class="fas fa-female"></i> Femme</option>
                                  </select>
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-calendar-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Date Naissance</label>
                                <input type="text" class="form-control" name="datenaissance" id="datenaissance" value="{{ old('datenaissance') }}"  style="background-color: transparent;" required>
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-map-marker-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Lieu Naissance</label>
                                <input type="text" class="form-control" name="lieunaissance" value="{{ old('lieunaissance') }}">
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-map-marked-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Région" name="region" required>
                                <option value="" disabled>Région</option>
			                          <option value="dakar">Dakar</option>
			                          <option value="diourbel">Diourbel</option>
			                          <option value="fatick">Fatick</option>
			                          <option value="kaffrine">Kaffrine</option>
			                          <option value="kaolack">Kaolack</option>
			                          <option value="kedougou">Kédougou</option>
			                          <option value="kolda">Kolda</option>
			                          <option value="louga">Louga</option>
			                          <option value="matam">Matam</option>
			                          <option value="saintLouis">Saint-Louis</option>
			                          <option value="sedhiou">Sédhiou</option>
			                          <option value="tambacounda">Tambacounda</option>
			                          <option value="thies">Thiès</option>
			                          <option value="ziguinchor">Ziguinchor</option>
                                <option value="etranger">Etranger</option>
                                <option value="inconnu">Inconnu</option>
                                  </select>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="tab-pane" id="account">
                        <div class="row justify-content-center">
                          <div class="col-lg-12">
                            <div class="row">

                          <div class="col-sm-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-mobile-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Phone 1</label>
                                <input type="text" class="form-control" name="phone1" value="{{ old('phone1') }}">
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-user-tie"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Père</label>
                                <input type="text" class="form-control" name="pere" value="{{ old('pere') }}" required>
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-user-tie"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Tuteur</label>
                                <input type="text" class="form-control" name="tuteur" value="{{ old('tuteur') }}" required>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-mobile-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Phone2</label>
                                <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}">
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-female"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Mère</label>
                                <input type="text" class="form-control" name="mere" value="{{ old('mere') }}" required>
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-map-marker-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Adresse</label>
                                <input type="text" class="form-control" value="{{ old('address') }}" name="adresse">
                              </div>
                            </div>
                          </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="address">
                        <div class="row justify-content-center">
                           <div class="col-sm-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-igloo"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Daara" name="daara_id" required>
                                  @foreach($daaras as $daara)
                                  <option value="{{ $daara->id }}">{{ $daara->nom }}</option>
                                  @endforeach

                                 </select>
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-calendar-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Arrivée</label>
                                <input type="text" style="background-color: transparent;" class="form-control" value="{{ old('arrivee') }}" name="arrivee"  id="arrivee" required>
                              </div>
                            </div>
                          </div>

                        </div>

                        <div class="row justify-content-center">
                          <div class="col-lg-12">
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">

                                </span>
                              </div>
                              <div class="form-group">
                                <label for="commentaire" style="color: #4CAF50 !important;">Commentaire</label>
                              <textarea class="form-control" id="commentaire" name="commentaire" rows="3" style="width: 115% !important;"
                            >{{ old('commentaire') }}</textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="mr-auto">
                      <input type="button" class="btn btn-previous btn-fill btn-default btn-wd disabled" name="previous" value="Précédent">
                    </div>
                    <div class="ml-auto">
                      <input type="button" class="btn btn-next btn-fill btn-success btn-wd" name="next" value="Suivant">
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

        //    $('#input-file').change(function(event) {

        //      var fileList = event.target.files;

        //      console.log(fileList);

        //    if (fileList.length) {
        //      $('#filename').text(fileList[0].name)
        //    }
        // });
    </script>
@endpush
