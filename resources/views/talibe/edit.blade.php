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
    @section('content')
        @if(auth()->user()->hasPermission('edit-talibes')
        || auth()->user()->is_admin
       )
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
                                 <select class="selectpicker" data-style="select-with-transition" title="Sexe" name="genre" required>
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
                                  {{--1--}}<option value="ALIF LAM MIIM" {{ $talibe->niveau == 'ALIF LAM MIIM' ? 'selected' :'' }}>ALIF LAM MIIM</option>
                                  {{--2--}}<option value="WA IZAA LAKHOU" {{ $talibe->niveau == 'WA IZAA LAKHOU"' ? 'selected' :'' }}>WA IZAA LAKHOU</option>
                                  {{--3--}}<option value="SAYAKHOULOU" {{ $talibe->niveau == 'SAYAKHOULOU' ? 'selected' :'' }}>SAYAKHOULOU</option>
                                  {{--4--}}<option value="WAZKOUROUL LAAHA" {{ $talibe->niveau == 'WAZKOUROUL LAAHA' ? 'selected' :'' }}>WAZKOUROUL LAAHA</option>
                                  {{--5--}}<option value="TILKA ROUSOULOU" {{ $talibe->niveau == 'TILKA ROUSOULOU' ? 'selected' :'' }}>TILKA ROUSOULOU</option>
                                  {{--6--}}<option value="KHOULAW NABI OUKOUM" {{ $talibe->niveau == 'KHOULAW NABI OUKOUMKHOULAW NABI OUKOUM' ? 'selected' :'' }}>KHOULAW NABI OUKOUM</option>
                                  {{--7--}}<option value="LANE TANAALOU" {{ $talibe->niveau == 'LANE TANAALOU' ? 'selected' :'' }}>LANE TANAALOU</option>
                                  {{--8--}}<option value="YASTABCHIROUNA" {{ $talibe->niveau == 'YASTABCHIROUNA' ? 'selected' :'' }}>YASTABCHIROUNA</option>
                                  {{--9--}}<option value="WAL MOUHSANAATOU" {{ $talibe->niveau == 'WAL MOUHSANAATOU' ? 'selected' :'' }}>WAL MOUHSANAATOU</option>
                                  {{--10--}}<option value="ALLAHOU LA ILAAHA ILLA HOUWA" {{ $talibe->niveau == 'ALLAHOU LA ILAAHA ILLA HOUWA' ? 'selected' :'' }}>ALLAHOU LA ILAAHA ILLA HOUWA</option>
                                  {{--11--}}<option value="LA YOUHIBOU" {{ $talibe->niveau == 'LA YOUHIBOU' ? 'selected' :'' }}>LA YOUHIBOU</option>
                                  {{--12--}}<option value="HAALOU RADJOULAANI" {{ $talibe->niveau == 'HAALOU RADJOULAANI' ? 'selected' :'' }}>HAALOU RADJOULAANI</option>
                                  {{--13--}}<option value="LA TADJIDANNA" {{ $talibe->niveau == 'LA TADJIDANNA' ? 'selected' :'' }}>LA TADJIDANNA</option>
                                  {{--14--}}<option value="INNAMAA YASTADJIIBOU" {{ $talibe->niveau == 'INNAMAA YASTADJIIBOU' ? 'selected' :'' }}>INNAMAA YASTADJIIBOU</option>
                                  {{--15--}}<option value="WALAWA ANNANAA" {{ $talibe->niveau == 'WALAWA ANNANAA' ? 'selected' :'' }}>WALAWA ANNANAA</option>
                                  {{--16--}}<option value="FAMAA KAANA DAKHWééHOUME" {{ $talibe->niveau == 'FAMAA KAANA DAKHWééHOUME' ? 'selected' :'' }}>FAMAA KAANA DAKHWééHOUME</option>
                                  {{--17--}}<option value="KHALAL MALA-OU" {{ $talibe->niveau == 'KHALAL MALA-OU' ? 'selected' :'' }}>KHALAL MALA-OU</option>
                                  {{--18--}}<option value="WA ISE NATAKHNAL DJABALA" {{ $talibe->niveau == 'WA ISE NATAKHNAL DJABALA' ? 'selected' :'' }}>WA ISE NATAKHNAL DJABALA</option>
                                  {{--19--}}<option value="WAKHLAMOU ANNAMA HANIMTOUME" {{ $talibe->niveau == 'WAKHLAMOU ANNAMA HANIMTOUME' ? 'selected' :'' }}>WAKHLAMOU ANNAMA HANIMTOUME</option>
                                  {{--20--}}<option value="YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE" {{ $talibe->niveau == 'YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE' ? 'selected' :'' }}>YA AYYOUHAL LEZIINA AAMANOU INNA KASIIRANE</option>
                                  {{--21--}}<option value="INNAMAS SABIILOU" {{ $talibe->niveau == 'INNAMAS SABIILOU' ? 'selected' :'' }}>INNAMAS SABIILOU</option>
                                  {{--22--}}<option value="LILEZIINA AHSANOU" {{ $talibe->niveau == 'LILEZIINA AHSANOU' ? 'selected' :'' }}>LILEZIINA AHSANOU</option>
                                  {{--23--}}<option value="WA MAA MINE DAABATINE" {{ $talibe->niveau == 'WA MAA MINE DAABATINE' ? 'selected' :'' }}>WA MAA MINE DAABATINE</option>
                                  {{--24--}}<option value="WA ILA MADEYANA" {{ $talibe->niveau == 'WA ILA MADEYANA' ? 'selected' :'' }}>WA ILA MADEYANA</option>
                                  {{--25--}}<option value="WAMA OUBARRI OU" {{ $talibe->niveau == 'WAMA OUBARRI OU' ? 'selected' :'' }}>WAMA OUBARRI OU</option>
                                  {{--26--}}<option value="AFAMANE YAKHLAMOU" {{ $talibe->niveau == 'AFAMANE YAKHLAMOU' ? 'selected' :'' }}>AFAMANE YAKHLAMOU</option>
                                  {{--27--}}<option value="ALIF RAM REE" {{ $talibe->niveau == 'ALIF RAM REE' ? 'selected' :'' }}>ALIF RAM REE</option>
                                  {{--28--}}<option value="WA KHAALAL LAAHOU" {{ $talibe->niveau == 'WA KHAALAL LAAHOU' ? 'selected' :'' }}>WA KHAALAL LAAHOU</option>
                                  {{--29--}}<option value="SOUBEHAANA LEUZII" {{ $talibe->niveau == 'SOUBEHAANA LEUZII' ? 'selected' :'' }}>SOUBEHAANA LEUZII</option>
                                  {{--30--}}<option value="AWALAM YARAWA" {{ $talibe->niveau == 'AWALAM YARAWA' ? 'selected' :'' }}>AWALAM YARAWA</option>
                                  {{--31--}}<option value="KHAALA ALAMA AKHOULE" {{ $talibe->niveau == 'KHAALA ALAMA AKHOULE' ? 'selected' :'' }}>KHAALA ALAMA AKHOULE</option>
                                  {{--32--}}<option value="TAA Héé" {{ $talibe->niveau == 'TAA Héé' ? 'selected' :'' }}>TAA Héé</option>
                                  {{--33--}}<option value="IKHTARABA" {{ $talibe->niveau == 'IKHTARABA' ? 'selected' :'' }}>IKHTARABA</option>
                                  {{--34--}}<option value="YA AYOUHAN-NAASSOU" {{ $talibe->niveau == 'YA AYOUHAN-NAASSOU' ? 'selected' :'' }}>YA AYOUHAN-NAASSOU</option>
                                  {{--35--}}<option value="KHAD AFLAKHA" {{ $talibe->niveau == 'KHAD AFLAKHA' ? 'selected' :'' }}>KHAD AFLAKHA</option>
                                  {{--36--}}<option value="YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU" {{ $talibe->niveau == 'YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU' ? 'selected' :'' }}>YA AYOUHAL LEUZIINA AAMANOU LAA TAT-TABI-OU</option>
                                  {{--37--}}<option value="WA KHALAL LEUZIINA" {{ $talibe->niveau == 'WA KHALAL LEUZIINA' ? 'selected' :'' }}>WA KHALAL LEUZIINA</option>
                                  {{--38--}}<option value="KHAALOU ANOUMINOU" {{ $talibe->niveau == 'KHAALOU ANOUMINOU' ? 'selected' :'' }}>KHAALOU ANOUMINOU</option>
                                  {{--30--}}<option value="FAMAA KAANA DJAWAABA" {{ $talibe->niveau == 'FAMAA KAANA DJAWAABA' ? 'selected' :'' }}>FAMAA KAANA DJAWAABA</option>
                                  {{--40--}}<option value="WA LAKHAD WASSALNAA" {{ $talibe->niveau == 'WA LAKHAD WASSALNAA' ? 'selected' :'' }}>WA LAKHAD WASSALNAA</option>
                                  {{--41--}}<option value="WALAA TOUDJADILOU" {{ $talibe->niveau == 'WALAA TOUDJADILOU' ? 'selected' :'' }}>WALAA TOUDJADILOU</option>
                                  {{--42--}}<option value="WA MANE YOUSSLIME" {{ $talibe->niveau == 'WA MANE YOUSSLIME' ? 'selected' :'' }}>WA MANE YOUSSLIME</option>
                                  {{--43--}}<option value="WA MANE YAKHNOUTE" {{ $talibe->niveau == 'WA MANE YAKHNOUTE' ? 'selected' :'' }}>WA MANE YAKHNOUTE</option>
                                  {{--44--}}<option value="KHOULE MANE YARZOUKHOUKOUME" {{ $talibe->niveau == 'KHOULE MANE YARZOUKHOUKOUME' ? 'selected' :'' }}>KHOULE MANE YARZOUKHOUKOUME</option>
                                  {{--45--}}<option value="WAMAA ANEZALNAA" {{ $talibe->niveau == 'WAMAA ANEZALNAA' ? 'selected' :'' }}>WAMAA ANEZALNAA</option>
                                  {{--46--}}<option value="FANABAZNAAHOU" {{ $talibe->niveau == 'FANABAZNAAHOU' ? 'selected' :'' }}>FANABAZNAAHOU</option>
                                  {{--47--}}<option value="FAMANAZELAMOU" {{ $talibe->niveau == 'FAMANAZELAMOU' ? 'selected' :'' }}>FAMANAZELAMOU</option>
                                  {{--48--}}<option value="WA YAAKHAWMI" {{ $talibe->niveau == 'WA YAAKHAWMI' ? 'selected' :'' }}>WA YAAKHAWMI</option>
                                  {{--49--}}<option value="ILAYHI YOURAD-DOU" {{ $talibe->niveau == 'ILAYHI YOURAD-DOU' ? 'selected' :'' }}>ILAYHI YOURAD-DOU</option>
                                  {{--50--}}<option value="KHOULA AWALAWE" {{ $talibe->niveau == 'KHOULA AWALAWE' ? 'selected' :'' }}>KHOULA AWALAWE</option>
                                  {{--51--}}<option value="HEE MIME" {{ $talibe->niveau == 'HEE MIME' ? 'selected' :'' }}>HEE MIME</option>
                                  {{--52--}}<option value="LAKHADE RADIYAL LAAHOU" {{ $talibe->niveau == 'LAKHADE RADIYAL LAAHOU' ? 'selected' :'' }}>LAKHADE RADIYAL LAAHOU</option>
                                  {{--53--}}<option value="KHAALA FAMAA KHATBOUKOUME" {{ $talibe->niveau == 'KHAALA FAMAA KHATBOUKOUME' ? 'selected' :'' }}>KHAALA FAMAA KHATBOUKOUME</option>
                                  {{--54--}}<option value="AR-RAHMANE" {{ $talibe->niveau == 'AR-RAHMANE' ? 'selected' :'' }}>AR-RAHMANE</option>
                                  {{--55--}}<option value="KHAD SAMIHA" {{ $talibe->niveau == 'KHAD SAMIHA' ? 'selected' :'' }}>KHAD SAMIHA</option>
                                  {{--56--}}<option value="YOUSSABIHOU" {{ $talibe->niveau == 'YOUSSABIHOU' ? 'selected' :'' }}>YOUSSABIHOU</option>
                                  {{--57--}}<option value="TABAARAKA" {{ $talibe->niveau == 'TABAARAKA' ? 'selected' :'' }}>TABAARAKA</option>
                                  {{--58--}}<option value="KHOULOU HIYA" {{ $talibe->niveau == 'KHOULOU HIYA' ? 'selected' :'' }}>KHOULOU HIYA</option>
                                  {{--59--}}<option value="HAMMA YATA" {{ $talibe->niveau == 'HAMMA YATA' ? 'selected' :'' }}>HAMMA YATA</option>
                                  {{--60--}}<option value="SABIHISMA" {{ $talibe->niveau == 'SABIHISMA' ? 'selected' :'' }}>SABIHISMA</option>
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
        @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Vous n'êtes pas autorisé <br> à faire cet action</h3>
                    </div>
                </div>
            </div>
        @endif
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
