@extends('layouts.scratch',['title' => 'Création d\'un nouveau Talibé | '])


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
                <form action="{{ route('talibe.update',['id' => $talibe->id]) }}" method="POST" enctype="multipart/form-data">
                	@csrf()
                  {{ method_field('PUT')}}
                  <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                  <div class="card-header text-center">
                    <h4 class="card-title">Talibé </h4>
                    <h5 class="card-description">Edition de profil.</h5>
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
                                <input type="text" class="form-control" name="prenom" value="{{ old('prenom') ?? $talibe->prenom }}" required>
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
                                <input type="text" class="form-control" name="nom" value="{{ old('nom') ?? $talibe->nom }}" required>
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
                                 <select class="selectpicker" data-style="select-with-transition" title="Genre" name="genre" required>
                                    <option value="1" {{ $talibe->genre == 1 ? 'selected' : ''}}><i class="fas fa-male"></i> Homme</option>
                                    <option value="0" {{ $talibe->genre == 0 ? 'selected' : ''}}><i class="fas fa-female"></i> Femme</option>
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
                                <input type="text" class="form-control" name="datenaissance" id="datenaissance" value="{{ old('datenaissance') ?? app_date_reverse($talibe->datenaissance,'-','/') }}"  style="background-color: transparent;">
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
                                <input type="text" class="form-control" name="lieunaissance" value="{{ old('lieunaissance') ?? $talibe->lieunaissance }}">
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-map-marked-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <select class="selectpicker" data-style="select-with-transition" title="Région" name="region">
                                <option value="" disabled>Région</option>
			                          <option value="dakar" {{ $talibe->region == 'dakar' ? 'selected' : ''}}>Dakar</option>
			                          <option value="diourbel" {{ $talibe->region == 'diourbel' ? 'selected' : ''}}>Diourbel</option>
			                          <option value="fatick" {{ $talibe->region == 'fatick' ? 'selected' : ''}}>Fatick</option>
			                          <option value="kaffrine" {{ $talibe->region == 'kaffrine' ? 'selected' : ''}}>Kaffrine</option>
			                          <option value="kaolack" {{ $talibe->region == 'kaolack' ? 'selected' : ''}}>Kaolack</option>
			                          <option value="kedougou" {{ $talibe->region == 'kedougou' ? 'selected' : ''}}>Kédougou</option>
			                          <option value="kolda" {{ $talibe->region == 'kolda' ? 'selected' : ''}}>Kolda</option>
			                          <option value="louga" {{ $talibe->region == 'louga' ? 'selected' : ''}}>Louga</option>
			                          <option value="matam" {{ $talibe->region == 'matam' ? 'selected' : ''}}>Matam</option>
			                          <option value="saintlouis" {{ $talibe->region == 'saintlouis' ? 'selected' : ''}}>Saint-Louis</option>
			                          <option value="sedhiou" {{ $talibe->region == 'sedhiou' ? 'selected' : ''}}>Sédhiou</option>
			                          <option value="tambacounda" {{ $talibe->region == 'tambacounda' ? 'selected' : ''}}>Tambacounda</option>
			                          <option value="thies" {{ $talibe->region == 'thies' ? 'selected' : ''}}>Thiès</option>
			                          <option value="ziguinchor" {{ $talibe->region == 'ziguinchor' ? 'selected' : ''}}>Ziguinchor</option>      
                                <option value="etranger" {{ $talibe->region == 'etranger' ? 'selected' : ''}}>Etranger</option>      
                                <option value="inconnu" {{ $talibe->region == 'inconnu' ? 'selected' : ''}}>Inconnu</option>      
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
                                <input type="text" class="form-control" name="phone1" value="{{ old('phone1') ?? $talibe->phone1 }}">
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
                                <input type="text" class="form-control" name="pere" value="{{ old('pere') ?? $talibe->pere }}">
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
                                <input type="text" class="form-control" name="tuteur" value="{{ old('tuteur') ?? $talibe->tuteur }}">
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
                                <input type="text" class="form-control" name="phone2" value="{{ old('phone2') ?? $talibe->phone2 }}">
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
                                <input type="text" class="form-control" name="mere" value="{{ old('mere') ?? $talibe->mere }}">
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
                                <input type="text" class="form-control" value="{{ old('adresse') ?? $talibe->adresse }}" name="adresse">
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
                                  <option value="{{ $daara->id }}" {{ $daara->id == $talibe->daara_id ? 'selected' : '' }}>{{ $daara->nom }}</option>
                                  @endforeach
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
                                <label for="exampleInput11" class="bmd-label-floating">Arrivée</label>
                                <input type="text" style="background-color: transparent;" class="form-control" value="{{ old('arrivee') ?? app_date_reverse($talibe->arrivee,'-','/') }}" name="arrivee"  id="arrivee">
                              </div>
                            </div>
                          </div>

                          <div class="col-sm-6">                      
                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-user-graduate"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                 <select class="selectpicker" data-style="select-with-transition" title="Dieuwrigne" name="dieuw_id">
                                  @foreach($dieuws as $dieuw)
                                  <option value="{{ $dieuw->id }}" {{ $dieuw->id == $talibe->dieuw_id ? 'selected' : '' }}>{{ $dieuw->fullname() }} - {{ $dieuw->daara->nom ?? ''}}</option>
                                  @endforeach
                                 </select>
                              </div>
                            </div>

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-book"></i>
                                </span>
                              </div>
                              <div class="form-group">
                              <select class="selectpicker" data-style="select-with-transition" title="Niveau" name="niveau">
                              <option value="">Niveau</option>
			                        <option value="1" {{ $talibe->niveau == 1 ? 'selected' :'' }}>ALIF LAM MIIM</option>
			                        <option value="2" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA IZAA LAKHOU</option>
			                        <option value="3" {{ $talibe->niveau == 1 ? 'selected' :'' }}>SAYAKHOULOU</option>
			                        <option value="4" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WAZKOUROUL LAAHA</option>
			                        <option value="5" {{ $talibe->niveau == 1 ? 'selected' :'' }}>TILKA ROUSOULOU</option>
			                        <option value="6" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHOULAW NABI OUKOUM</option>
			                        <option value="7" {{ $talibe->niveau == 1 ? 'selected' :'' }}>LANE TANAALOU</option>
			                        <option value="8" {{ $talibe->niveau == 1 ? 'selected' :'' }}>YASTABCHIROUNA</option>
			                        <option value="9" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WAL MOUHSANAATOU</option>
			                        <option value="10" {{ $talibe->niveau == 1 ? 'selected' :'' }}>ALLAHOU LA ILAAHA ILLA HOUWA</option>
			                        <option value="11" {{ $talibe->niveau == 1 ? 'selected' :'' }}>LA YOUHIBOU</option>
			                        <option value="12" {{ $talibe->niveau == 1 ? 'selected' :'' }}>HAALOU RADJOULAANI</option>
			                        <option value="13" {{ $talibe->niveau == 1 ? 'selected' :'' }}>LA TADJIDANNA</option>
			                        <option value="14" {{ $talibe->niveau == 1 ? 'selected' :'' }}>INNAMAA YASTADJIIBOU</option>
			                        <option value="15" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WALAWA ANNANAA</option>
			                        <option value="16" {{ $talibe->niveau == 1 ? 'selected' :'' }}>FAMAA KAANA DAKHWééHOUME</option>
			                        <option value="17" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHALAL MALA-OU</option>
			                        <option value="18" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA ISE NATAKHNAL DJABALA</option>
			                        <option value="19" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WAKHLAMOU ANNAMA HANIMTOUME</option>
			                        <option value="20" {{ $talibe->niveau == 1 ? 'selected' :'' }}>YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE</option>
			                        <option value="21" {{ $talibe->niveau == 1 ? 'selected' :'' }}>INNAMAS SABIILOU</option>
			                        <option value="22" {{ $talibe->niveau == 1 ? 'selected' :'' }}>LILEZIINA AHSANOU</option>
			                        <option value="23" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA MAA MINE DAABATINE</option>
			                        <option value="24" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA ILA MADEYANA</option>
			                        <option value="25" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WAMA OUBARRI OU</option>
			                        <option value="26" {{ $talibe->niveau == 1 ? 'selected' :'' }}>AFAMANE YAKHLAMOU</option>
			                        <option value="27" {{ $talibe->niveau == 1 ? 'selected' :'' }}>ALIF RAM REE</option>
			                        <option value="28" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA KHAALAL LAAHOU</option>
			                        <option value="29" {{ $talibe->niveau == 1 ? 'selected' :'' }}>SOUBEHAANA LEUZII</option>
			                        <option value="30" {{ $talibe->niveau == 1 ? 'selected' :'' }}>AWALAM YARAWA</option>
			                        <option value="31" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHAALA ALAMA AKHOULE</option>
			                        <option value="32" {{ $talibe->niveau == 1 ? 'selected' :'' }}>TAA Héé</option>
			                        <option value="33" {{ $talibe->niveau == 1 ? 'selected' :'' }}>IKHTARABA</option>
			                        <option value="34" {{ $talibe->niveau == 1 ? 'selected' :'' }}>YA AYOUHAN-NAASSOU</option>
			                        <option value="35" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHAD AFLAKHA</option>
			                        <option value="36" {{ $talibe->niveau == 1 ? 'selected' :'' }}>YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU</option>
			                        <option value="37" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA KHALAL LEUZIINA</option>
			                        <option value="38" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHAALOU ANOUMINOU</option>
			                        <option value="39" {{ $talibe->niveau == 1 ? 'selected' :'' }}>FAMAA KAANA DJAWAABA</option>
			                        <option value="40" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA LAKHAD WASSALNAA</option>
			                        <option value="41" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WALAA TOUDJADILOU</option>
			                        <option value="42" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA MANE YOUSSLIME</option>
			                        <option value="43" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA MANE YAKHNOUTE</option>
			                        <option value="44" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHOULE MANE YARZOUKHOUKOUME></option>
			                        <option value="45" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WAMAA ANEZALNAA</option>
			                        <option value="46" {{ $talibe->niveau == 1 ? 'selected' :'' }}>FANABAZNAAHOU</option>
			                        <option value="47" {{ $talibe->niveau == 1 ? 'selected' :'' }}>FAMANAZELAMOU</option>
			                        <option value="48" {{ $talibe->niveau == 1 ? 'selected' :'' }}>WA YAAKHAWMI</option>
			                        <option value="49" {{ $talibe->niveau == 1 ? 'selected' :'' }}>ILAYHI YOURAD-DOU</option>
			                        <option value="50" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHOULA AWALAWE</option>
			                        <option value="51" {{ $talibe->niveau == 1 ? 'selected' :'' }}>HEE MIME</option>
			                        <option value="52" {{ $talibe->niveau == 1 ? 'selected' :'' }}>LAKHADE RADIYAL LAAHOU</option>
			                        <option value="53" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHAALA FAMAA KHATBOUKOUME</option>
			                        <option value="54" {{ $talibe->niveau == 1 ? 'selected' :'' }}>AR-RAHMANE</option>
			                        <option value="55" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHAD SAMIHA</option>
			                        <option value="56" {{ $talibe->niveau == 1 ? 'selected' :'' }}>YOUSSABIHOU</option>
			                        <option value="57" {{ $talibe->niveau == 1 ? 'selected' :'' }}>TABAARA</option>
			                        <option value="58" {{ $talibe->niveau == 1 ? 'selected' :'' }}>KHOULOU HIYA</option>
			                        <option value="59" {{ $talibe->niveau == 1 ? 'selected' :'' }}>HAMMA YATA</option>
			                        <option value="60" {{ $talibe->niveau == 1 ? 'selected' :'' }}>SABIHISMA</option>
                                </select>
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
                                <label for="commentaire" style="color: #4CAF50;">Commentaire</label>
                              <textarea class="form-control" id="commentaire" name="commentaire" rows="3" style="width: 115% !important;"
                              >{{ old('commentaire') ?? $talibe->commentaire }}</textarea>
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