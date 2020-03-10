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
                                  {{--1--}}<option value="ALIF LAM MIIM">ALIF LAM MIIM</option>
                                  {{--2--}}<option value="WA IZAA LAKHOU">WA IZAA LAKHOU</option>
                                  {{--3--}}<option value="SAYAKHOULOU">SAYAKHOULOU</option>
                                  {{--4--}}<option value="WAZKOUROUL LAAHA">WAZKOUROUL LAAHA</option>
                                  {{--5--}}<option value="TILKA ROUSOULOU">TILKA ROUSOULOU</option>
                                  {{--6--}}<option value="KHOULAW NABI OUKOUM">KHOULAW NABI OUKOUM</option>
                                  {{--7--}}<option value="LANE TANAALOU">LANE TANAALOU</option>
                                  {{--8--}}<option value="YASTABCHIROUNA">YASTABCHIROUNA</option>
                                  {{--9--}}<option value="WAL MOUHSANAATOU">WAL MOUHSANAATOU</option>
                                  {{--10--}}<option value="ALLAHOU LA ILAAHA ILLA HOUWA">ALLAHOU LA ILAAHA ILLA HOUWA</option>
                                  {{--11--}}<option value="LA YOUHIBOU">LA YOUHIBOU</option>
                                  {{--12--}}<option value="HAALOU RADJOULAANI">HAALOU RADJOULAANI</option>
                                  {{--13--}}<option value="LA TADJIDANNA">LA TADJIDANNA</option>
                                  {{--14--}}<option value="INNAMAA YASTADJIIBOU">INNAMAA YASTADJIIBOU</option>
                                  {{--15--}}<option value="WALAWA ANNANAA">WALAWA ANNANAA</option>
                                  {{--16--}}<option value="FAMAA KAANA DAKHWééHOUME">FAMAA KAANA DAKHWééHOUME</option>
                                  {{--17--}}<option value="KHALAL MALA-OU">KHALAL MALA-OU</option>
                                  {{--18--}}<option value="WA ISE NATAKHNAL DJABALA">WA ISE NATAKHNAL DJABALA</option>
                                  {{--19--}}<option value="WAKHLAMOU ANNAMA HANIMTOUME">WAKHLAMOU ANNAMA HANIMTOUME</option>
                                  {{--20--}}<option value="YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE">YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE</option>
                                  {{--21--}}<option value="INNAMAS SABIILOU">INNAMAS SABIILOU</option>
                                  {{--22--}}<option value="LILEZIINA AHSANOU">LILEZIINA AHSANOU</option>
                                  {{--23--}}<option value="WA MAA MINE DAABATINE">WA MAA MINE DAABATINE</option>
                                  {{--24--}}<option value="WA ILA MADEYANA">WA ILA MADEYANA</option>
                                  {{--25--}}<option value="WAMA OUBARRI OU">WAMA OUBARRI OU</option>
                                  {{--26--}}<option value="AFAMANE YAKHLAMOU">AFAMANE YAKHLAMOU</option>
                                  {{--27--}}<option value="ALIF RAM REE">ALIF RAM REE</option>
                                  {{--28--}}<option value="WA KHAALAL LAAHOU">WA KHAALAL LAAHOU</option>
                                  {{--29--}}<option value="SOUBEHAANA LEUZII">SOUBEHAANA LEUZII</option>
                                  {{--30--}}<option value="AWALAM YARAWA">AWALAM YARAWA</option>
                                  {{--31--}}<option value="KHAALA ALAMA AKHOULE">KHAALA ALAMA AKHOULE</option>
                                  {{--32--}}<option value="TAA Héé">TAA Héé</option>
                                  {{--33--}}<option value="IKHTARABA">IKHTARABA</option>
                                  {{--34--}}<option value="YA AYOUHAN-NAASSOU">YA AYOUHAN-NAASSOU</option>
                                  {{--35--}}<option value="KHAD AFLAKHA">KHAD AFLAKHA</option>
                                  {{--36--}}<option value="YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU">YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU</option>
                                  {{--37--}}<option value="WA KHALAL LEUZIINA">WA KHALAL LEUZIINA</option>
                                  {{--38--}}<option value="KHAALOU ANOUMINOU">KHAALOU ANOUMINOU</option>
                                  {{--39--}}<option value="FAMAA KAANA DJAWAABA">FAMAA KAANA DJAWAABA</option>
                                  {{--40--}}<option value="WA LAKHAD WASSALNAA">WA LAKHAD WASSALNAA</option>
                                  {{--41--}}<option value="WALAA TOUDJADILOU">WALAA TOUDJADILOU</option>
                                  {{--42--}}<option value="WA MANE YOUSSLIME">WA MANE YOUSSLIME</option>
                                  {{--43--}}<option value="WA MANE YAKHNOUTE">WA MANE YAKHNOUTE</option>
                                  {{--44--}}<option value="KHOULE MANE YARZOUKHOUKOUME">KHOULE MANE YARZOUKHOUKOUME</option>
                                  {{--45--}}<option value="WAMAA ANEZALNAA">WAMAA ANEZALNAA</option>
                                  {{--46--}}<option value="FANABAZNAAHOU">FANABAZNAAHOU</option>
                                  {{--47--}}<option value="FAMANAZELAMOU">FAMANAZELAMOU</option>
                                  {{--48--}}<option value="WA YAAKHAWMI">WA YAAKHAWMI</option>
                                  {{--49--}}<option value="ILAYHI YOURAD-DOU">ILAYHI YOURAD-DOU</option>
                                  {{--50--}}<option value="KHOULA AWALAWE">KHOULA AWALAWE</option>
                                  {{--51--}}<option value="HEE MIME">HEE MIME</option>
                                  {{--52--}}<option value="LAKHADE RADIYAL LAAHOU">LAKHADE RADIYAL LAAHOU</option>
                                  {{--53--}}<option value="KHAALA FAMAA KHATBOUKOUME">KHAALA FAMAA KHATBOUKOUME</option>
                                  {{--54--}}<option value="AR-RAHMANE">AR-RAHMANE</option>
                                  {{--55--}}<option value="KHAD SAMIHA">KHAD SAMIHA</option>
                                  {{--56--}}<option value="YOUSSABIHOU">YOUSSABIHOU</option>
                                  {{--57--}}<option value="TABAARAKA">TABAARAKA</option>
                                  {{--58--}}<option value="KHOULOU HIYA">KHOULOU HIYA</option>
                                  {{--59--}}<option value="HAMMA YATA">HAMMA YATA</option>
                                  {{--60--}}<option value="SABIHISMA">SABIHISMA</option>
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
