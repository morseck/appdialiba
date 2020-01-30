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
                <form action="{{ route('talibe.store') }}" method="POST" enctype="multipart/form-data">
                	@csrf()
                  <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                  <div class="card-header text-center">
                    <h4 class="card-title">Talibé N° {{ nb_talibes() + 1 }}</h4>
                    <h5 class="card-description">Création d'un nouveau Talibé.</h5>
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
                                 <select class="selectpicker" data-style="select-with-transition" title="Genre" name="genre" required>
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
                                <input type="text" class="form-control" name="datenaissance" id="datenaissance" value="{{ old('datenaissance') }}"  style="background-color: transparent;">
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
                                <select class="selectpicker" data-style="select-with-transition" title="Région" name="region">
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
                                <input type="text" class="form-control" name="pere" value="{{ old('pere') }}">
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
                                <input type="text" class="form-control" name="tuteur" value="{{ old('tuteur') }}">
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
                                <input type="text" class="form-control" name="mere" value="{{ old('mere') }}">
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

                            <div class="input-group form-control-lg">
                              <div class="input-group-prepend">
                                <span class="input-group-text">
                                  <i class="fas fa-calendar-alt"></i>
                                </span>
                              </div>
                              <div class="form-group">
                                <label for="exampleInput11" class="bmd-label-floating">Arrivée</label>
                                <input type="text" style="background-color: transparent;" class="form-control" value="{{ old('arrivee') }}" name="arrivee"  id="arrivee">
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
                                  <option value="{{ $dieuw->id }}">{{ $dieuw->fullname() }} - {{ $dieuw->daara->nom ?? ''}}</option>
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
			                        <option value="1">ALIF LAM MIIM</option>
			                        <option value="2">WA IZAA LAKHOU</option>
			                        <option value="3">SAYAKHOULOU</option>
			                        <option value="4">WAZKOUROUL LAAHA</option>
			                        <option value="5">TILKA ROUSOULOU</option>
			                        <option value="6">KHOULAW NABI OUKOUM</option>
			                        <option value="7">LANE TANAALOU</option>
			                        <option value="8">YASTABCHIROUNA</option>
			                        <option value="9">WAL MOUHSANAATOU</option>
			                        <option value="10">ALLAHOU LA ILAAHA ILLA HOUWA</option>
			                        <option value="11">LA YOUHIBOU</option>
			                        <option value="12">HAALOU RADJOULAANI</option>
			                        <option value="13">LA TADJIDANNA</option>
			                        <option value="14">INNAMAA YASTADJIIBOU</option>
			                        <option value="15">WALAWA ANNANAA</option>
			                        <option value="16">FAMAA KAANA DAKHWééHOUME</option>
			                        <option value="17">KHALAL MALA-OU</option>
			                        <option value="18">WA ISE NATAKHNAL DJABALA</option>
			                        <option value="19">WAKHLAMOU ANNAMA HANIMTOUME</option>
			                        <option value="20">YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE</option>
			                        <option value="21">INNAMAS SABIILOU</option>
			                        <option value="22">LILEZIINA AHSANOU</option>
			                        <option value="23">WA MAA MINE DAABATINE</option>
			                        <option value="24">WA ILA MADEYANA</option>
			                        <option value="25">WAMA OUBARRI OU</option>
			                        <option value="26">AFAMANE YAKHLAMOU</option>
			                        <option value="27">ALIF RAM REE</option>
			                        <option value="28">WA KHAALAL LAAHOU</option>
			                        <option value="29">SOUBEHAANA LEUZII</option>
			                        <option value="30">AWALAM YARAWA</option>
			                        <option value="31">KHAALA ALAMA AKHOULE</option>
			                        <option value="32">TAA Héé</option>
			                        <option value="33">IKHTARABA</option>
			                        <option value="34">YA AYOUHAN-NAASSOU</option>
			                        <option value="35">KHAD AFLAKHA</option>
			                        <option value="36">YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU</option>
			                        <option value="37">WA KHALAL LEUZIINA</option>
			                        <option value="38">KHAALOU ANOUMINOU</option>
			                        <option value="39">FAMAA KAANA DJAWAABA</option>
			                        <option value="40">WA LAKHAD WASSALNAA</option>
			                        <option value="41">WALAA TOUDJADILOU</option>
			                        <option value="42">WA MANE YOUSSLIME</option>
			                        <option value="43">WA MANE YAKHNOUTE</option>
			                        <option value="44">KHOULE MANE YARZOUKHOUKOUME></option>
			                        <option value="45">WAMAA ANEZALNAA</option>
			                        <option value="46">FANABAZNAAHOU</option>
			                        <option value="47">FAMANAZELAMOU</option>
			                        <option value="48">WA YAAKHAWMI</option>
			                        <option value="49">ILAYHI YOURAD-DOU</option>
			                        <option value="50">KHOULA AWALAWE</option>
			                        <option value="51">HEE MIME</option>
			                        <option value="52">LAKHADE RADIYAL LAAHOU</option>
			                        <option value="53">KHAALA FAMAA KHATBOUKOUME</option>
			                        <option value="54">AR-RAHMANE</option>
			                        <option value="55">KHAD SAMIHA</option>
			                        <option value="56">YOUSSABIHOU</option>
			                        <option value="57">TABAARA</option>
			                        <option value="58">KHOULOU HIYA</option>
			                        <option value="59">HAMMA YATA</option>
			                        <option value="60">SABIHISMA</option>
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