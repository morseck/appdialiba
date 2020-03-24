@extends('layouts.scratch',['titre' => 'Acceuil'])

@section('content')
	<div class="row">
    <div class="col-lg-11 card" style="margin:auto;">
      <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
          <div class="card-header card-header-warning card-header-icon">
              <a href="{{ route('dieuw.index') }}" class="text-white">
                 <div class="card-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
              </a>
              <a href="{{ route('dieuw.index') }}">
                  <p class="card-category">Dieuwrignes</p>
                  <h3 class="card-title">{{ nb_dieuws() }}</h3>
              </a>
          </div>
          <div class="card-footer">
            <div class="stats">
              <!-- <i class="material-icons text-danger">warning</i> -->
              <a href="{{ route('dieuw.index') }}"> Liste des Dieuwrigne</a>
            </div>
          </div>
        </div>
      </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1);">
              <div class="card-header card-header-rose card-header-icon">
                  <a href="{{ route('daara.index') }}" class="text-white">
                    <div class="card-icon">
                        <i class="fas fa-igloo"></i>
                    </div>
                  </a>
                  <a href="{{ route('daara.index') }}">
                      <p class="card-category">Daaras</p>
                      <h3 class="card-title">{{ nb_daaras() }}</h3>
                  </a>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons">local_offer</i>  -->
                  <a href="{{ route('daara.index') }}"> Liste des Daaras</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1);">
              <div class="card-header card-header-success card-header-icon">
                  <a href="{{ route('talibe.index') }}" class="text-white">
                     <div class="card-icon">
                        <i class='fas fa-users'></i>
                     </div>
                  </a>
                  <a href="{{ route('talibe.index') }}">
                      <p class="card-category">Talibés</p>
                      <h3 class="card-title">{{ nb_talibes() }}</h3>
                  </a>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons">date_range</i> -->
                  <a href="{{ route('talibe.index') }}"> Liste des Talibés</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1);">
                  <div class="card-header card-header-default card-header-icon">
                      <a href="{{ route('medecin.index') }}" class="text-white">
                          <div class="card-icon">
                            <i class='fas fa-user-md'></i>
                          </div>
                      </a>
                      <a href="{{ route('medecin.index') }}">
                          <p class="card-category">Médecins</p>
                          <h3 class="card-title">{{ nb_medecins() }}</h3>
                      </a>
                  </div>
                  <div class="card-footer">
                      <div class="stats">
                          <!-- <i class="material-icons">date_range</i> -->
                          <a href="{{ route('medecin.index') }}"> Liste des Médecins</a>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="card card-stats" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1);">
                  <div class="card-header card-header-info card-header-icon">
                      <a href="{{ route('tarbiya.index') }}" class="text-white">
                          <div class="card-icon">
                              <i class='fas fa-male'></i>
                          </div>
                      </a>
                      <a href="{{ route('tarbiya.index') }}">
                          <p class="card-category">Ngongos Tarbiya</p>
                          <h3 class="card-title">{{nb_tarbiyas()}}</h3>
                      </a>
                  </div>
                  <div class="card-footer">
                      <div class="stats">
                          <!-- <i class="material-icons">date_range</i> -->
                          <a href="{{ route('tarbiya.index') }}"> Liste des ndongos tarbiya</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
<br><br>
  <div class="row">
    <div class="col-lg-10 card" style="margin: auto;">
      <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
              <div class="card-header card-header-icon card-header-info">
                <div class="card-icon">
                  <i class="material-icons">pie_chart</i>
                </div>
                <h5 class="card-title">Répartitions des talibés en <b>fonctions des Daaras</b>
                  <!-- <small> - Rounded</small> -->
                </h5>
              </div>
              <div class="card-body">
                <canvas id="myChart1"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
              <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
                  <div class="card-header card-header-icon card-header-success">
                      <div class="card-icon">
                          <i class="material-icons">insert_chart</i>
                      </div>
                      <h4 class="card-title">Répartition des talibés en <b> fonctions des régions</b>
                          <!-- <small> - Rounded</small> -->
                      </h4>
                  </div>
                  <div class="card-body">
                      <canvas id="myChart2"></canvas>
                  </div>
              </div>
          </div>
          <div class="col-lg-12 col-md-12">
              <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
                  <div class="card-header card-header-icon card-header-warning">
                      <div class="card-icon">
                          <i class="material-icons">insert_chart</i>
                      </div>
                      <h4 class="card-title">Répartition des talibés en <b>fonctions des hizibs</b>
                          <!-- <small> - Rounded</small> -->
                      </h4>
                  </div>
                  <div class="card-body">
                      <canvas id="myChart3"></canvas>
                  </div>
              </div>
          </div>
          <div class="col-lg-12 col-md-12">
              <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
                  <div class="card-header card-header-icon card-header-danger">
                      <div class="card-icon">
                          <i class="material-icons">insert_chart</i>
                      </div>
                      <h4 class="card-title">Répartition des talibés en <b>des serignes daara</b>
                          <!-- <small> - Rounded</small> -->
                      </h4>
                  </div>
                  <div class="card-body">
                      <canvas id="myChart4"></canvas>
                  </div>
              </div>
          </div>
          <div class="col-lg-6 col-md-6">
              <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
                  <div class="card-header card-header-icon card-header-default">
                      <div class="card-icon">
                          <i class="material-icons">pie_chart</i>
                      </div>
                      <h4 class="card-title">Répartition des <b>Ndongos Tarbiya</b> en fonction des daaras
                          <!-- <small> - Rounded</small> -->
                      </h4>
                  </div>
                  <div class="card-body">
                      <canvas id="myChart5"></canvas>
                  </div>
              </div>
          </div>
          <div class="col-lg-6 col-md-6">
              <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
                  <div class="card-header card-header-icon card-header-success">
                      <div class="card-icon">
                          <i class="material-icons">insert_chart</i>
                      </div>
                      <h4 class="card-title">Répartition des <b>Médecins</b> en fonction de leurs spécialités
                          <!-- <small> - Rounded</small> -->
                      </h4>
                  </div>
                  <div class="card-body">
                      <canvas id="myChart6"></canvas>
                  </div>
              </div>
          </div>
          <div class="col-lg-12 col-md-12">
              <div class="card" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
                  <div class="card-header card-header-icon card-header-danger">
                      <div class="card-icon">
                          <i class="material-icons">insert_chart</i>
                      </div>
                      <h4 class="card-title">Répartition des <b>Maladies</b> en fonction de leur apparution
                          <!-- <small> - Rounded</small> -->
                      </h4>
                  </div>
                  <div class="card-body">
                      <canvas id="myChart7"></canvas>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
    {{--Diagramme--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
        var talibes = 0;
        var myLabels = [] ;
        var myData =[] ;

        var niveaux = 0;
        var myLabelNiveaux = [] ;
        var mydataNiveaus =[] ;

        var regions = 0;
        var myLabelRegions = [] ;
        var myDataRegions =[] ;

        var dieuwrines = 0;
        var myLabeldieuwrines = [] ;
        var myDatadieuwrines =[] ;

        var tarbiyas = 0;
        var myLabeltarbiyas = [] ;
        var myDatatarbiyas =[] ;

        var medecins = 0;
        var myLabelmedecins= [] ;
        var myDatamedecins =[] ;

        var maladies = 0;
        var myLabelmaladies= [] ;
        var myDatamaladies =[] ;

        var myBackgroundColors =[] ;

        function randomColor()
        {
            var r=g=b=0;

            r = Math.floor((Math.random()* 254) ) ;
            g = Math.floor((Math.random()* 254) ) ;
            b = Math.floor((Math.random()* 254) ) ;

            return 'rgba('+r+','+g+','+b+',1)' ;
        }
    </script>
    <?php foreach ($parts as $key => $part) : ?>
    <script type="text/javascript">
        myLabels.push('<?= $part->nom ?>') ;
        myData.push('{{ $part->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partNiveaux as $key => $p) : ?>
    <script type="text/javascript">
        myLabelNiveaux.push('<?= $p->niveau ?>') ;
        mydataNiveaus.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partRegions as $key => $p) : ?>
    <script type="text/javascript">
        myLabelRegions.push('<?= $p->region ?>') ;
        myDataRegions.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partDieuwrines as $key => $p) : ?>
    <script type="text/javascript">
        myLabeldieuwrines.push('<?= $p->fullname ?>') ;
        myDatadieuwrines.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partTarbiyas as $key => $p) : ?>
    <script type="text/javascript">
        myLabeltarbiyas.push('<?= $p->nom ?>') ;
        myDatatarbiyas.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partMedecins as $key => $p) : ?>
    <script type="text/javascript">
        myLabelmedecins.push('<?= $p->spec ?>') ;
        myDatamedecins.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    <?php foreach ($partMaladies as $key => $p) : ?>
    <script type="text/javascript">
        myLabelmaladies.push('<?= $p->maladie ?>') ;
        myDatamaladies.push('{{ $p->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>

    {{--Omar--}}
    <script type="text/javascript">
        for(var i=0,l=myData.length; i < l ; i++ ) {
            talibes += parseInt(myData[i]) ;
        }

        for(var i=0,l=mydataNiveaus.length; i < l ; i++ ) {
            // console.log(mydataNiveaus[i]);
            niveaux += parseInt(mydataNiveaus[i]) ;
        }

        for(var i=0,l=myDataRegions.length; i < l ; i++ ) {
            // console.log(mydataNiveaus[i]);
            regions += parseInt(myDataRegions[i]) ;
        }


        for(var i=0,l=myDatadieuwrines.length; i < l ; i++ ) {
            // console.log(mydataNiveaus[i]);
            dieuwrines += parseInt(myDatadieuwrines[i]) ;
        }

        for(var i=0,l=myDatatarbiyas.length; i < l ; i++ ) {
            tarbiyas += parseInt(myDatatarbiyas[i]) ;
        }

        for(var i=0,l=myDatamedecins.length; i < l ; i++ ) {
            medecins += parseInt(myDatamedecins[i]) ;
        }


        for(var i=0,l=myDatamaladies.length; i < l ; i++ ) {
            maladies += parseInt(myDatamaladies[i]) ;
        }


        console.log('talibes: '+talibes);
        console.log('Dieuwrines: '+dieuwrines);
        console.log('Niveau: '+niveaux);
        console.log('regions: '+regions);
        console.log('tarbiyas: '+tarbiyas);
        console.log('medecins: '+medecins);
        console.log('maladies: '+maladies);

        for(var i=0,l=myData.length; i < l ; i++ )
        {
            myLabels[i] += ' ('+ ((myData[i] / talibes ) * 100 ).toFixed(2) +' %)'+'  ['+myData[i]+']' ;
        }

        for(var i=0,l=mydataNiveaus.length; i < l ; i++ )
        {
            myLabelNiveaux[i] += ' ('+ ((mydataNiveaus[i] / niveaux ) * 100 ).toFixed(2) +' %)'+'  ['+mydataNiveaus[i]+']' ;
        }

        for(var i=0,l=myDataRegions.length; i < l ; i++ )
        {
            myLabelRegions[i] += ' ('+ ((myDataRegions[i] / regions ) * 100 ).toFixed(2) +' %)'+'  ['+myDataRegions[i]+']' ;
        }

        for(var i=0,l=myDatadieuwrines.length; i < l ; i++ )
        {
            myLabeldieuwrines[i] += ' ('+ ((myDatadieuwrines[i] / dieuwrines ) * 100 ).toFixed(2) +' %)'+'  ['+myDatadieuwrines[i]+']' ;
        }


        for(var i=0,l=myDatatarbiyas.length; i < l ; i++ )
        {
            myLabeltarbiyas[i] += ' ('+ ((myDatatarbiyas[i] / tarbiyas ) * 100 ).toFixed(2) +' %)'+'  ['+myDatatarbiyas[i]+']' ;
        }


        for(var i=0,l=myDatamedecins.length; i < l ; i++ )
        {
            myLabelmedecins[i] += ' ('+ ((myDatamedecins[i] / medecins ) * 100 ).toFixed(2) +' %)'+'  ['+myDatamedecins[i]+']' ;
        }


        for(var i=0,l=myDatamaladies.length; i < l ; i++ )
        {
            myLabelmaladies[i] += ' ('+ ((myDatamaladies[i] / maladies ) * 100 ).toFixed(2) +' %)'+'  ['+myDatamaladies[i]+']' ;
        }



        myData.push(0);
        mydataNiveaus.push(0);
        myDataRegions.push(0);
        myDatadieuwrines.push(0);
        myDatatarbiyas.push(0);
        myDatamedecins.push(0);
        myDatamaladies.push(0);

        var ctx1 = document.getElementById('myChart1');
        var ctx2 = document.getElementById('myChart2');
        var ctx3 = document.getElementById('myChart3');
        var ctx4 = document.getElementById('myChart4');
        var ctx5 = document.getElementById('myChart5');
        var ctx6 = document.getElementById('myChart6');
        var ctx7 = document.getElementById('myChart7');

        var data = {
            labels: myLabels,
            datasets: [{
                label: '# Daara',
                data: myData,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;
        var dataNiveau = {
            labels: myLabelNiveaux,
            datasets: [{
                label: '#Hizibs',
                data: mydataNiveaus,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;
        var dataRegion = {
            labels: myLabelRegions,
            datasets: [{
                label: '#Regions',
                data: myDataRegions,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;
        var dataDieuwrine = {
            labels: myLabeldieuwrines,
            datasets: [{
                label: '#Dieuwrines',
                data: myDatadieuwrines,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;

        var dataTarbiya = {
            labels: myLabeltarbiyas,
            datasets: [{
                label: '#Ndongos Tarbiya',
                data: myDatatarbiyas,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;


        var dataMedecin = {
            labels: myLabelmedecins,
            datasets: [{
                label: '#Medecins',
                data: myDatamedecins,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;


        var dataMaladie = {
            labels: myLabelmaladies,
            datasets: [{
                label: '#Maladies',
                data: myDatamaladies,
                backgroundColor: myBackgroundColors,
                borderColor: myBackgroundColors,
                borderWidth: 1,
                barPercentage: 1,
                barThickness: 6,
                maxBarThickness: 8,
                minBarLength: 2,
            }]
        } ;

        var myChart1 = new Chart(ctx1,{
            type: 'doughnut',
            data: data,
            options: {
                legend:{
                    display:false
                }
            }
        });

        var myChart2 = new Chart(ctx2,{
            type: 'horizontalBar',
            data: dataRegion,
            options: {

                legend:{
                    display:false
                }
            }
        });

        var myChart3 = new Chart(ctx3,{
            type: 'bar',
            data: dataNiveau,
            options: {

                legend:{
                    display:true
                }
            }
        });


        var myChart4 = new Chart(ctx4,{
            type: 'horizontalBar',
            data: dataDieuwrine,
            options: {

                legend:{
                    display:false
                }
            }
        });


        var myChart5 = new Chart(ctx5,{
            type: 'doughnut',
            data: dataTarbiya,
            options: {
                legend:{
                    display:false
                }
            }
        });


        var myChart6 = new Chart(ctx6,{
            type: 'horizontalBar',
            data: dataMedecin,
            options: {
                legend:{
                    display:false
                }
            }
        });


        var myChart7 = new Chart(ctx7,{
            type: 'bar',
            data: dataMaladie,
            options: {
                legend:{
                    display:true
                }
            }
        });


    </script>
@endpush
