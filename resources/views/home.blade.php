@extends('layouts.scratch',['titre' => 'Acceuil'])

@section('content')
	<div class="row">
    <div class="col-lg-10 card" style="margin:auto;">
      <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card card-stats" style="background-color: #eeeeee; border: 0.3px solid rgba(0,0,0,0.1)">
          <div class="card-header card-header-warning card-header-icon">
            <div class="card-icon">
              <i class="fas fa-user-graduate"></i>
            </div>
            <p class="card-category">Dieuwrignes</p>
            <h3 class="card-title">{{ nb_dieuws() }}</h3>
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
                <div class="card-icon">
                  <i class="fas fa-igloo"></i>
                </div>
                <p class="card-category">Daaras</p>
                <h3 class="card-title">{{ nb_daaras() }}</h3>
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
                <div class="card-icon">
                  <i class='fas fa-users'></i>
                </div>
                <p class="card-category">Talibés</p>
                <h3 class="card-title">{{ nb_talibes() }}</h3>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <!-- <i class="material-icons">date_range</i> -->
                  <a href="{{ route('talibe.index') }}"> Liste des Talibés</a>
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
            <div class="card" style="background-color: #eeeeee;">
              <div class="card-header card-header-icon card-header-info">
                <div class="card-icon">
                  <i class="material-icons">timeline</i>
                </div>
                <h4 class="card-title">Répartition des talibés
                  <!-- <small> - Rounded</small> -->
                </h4>
              </div>
              <div class="card-body">
                <canvas id="pieChart"></canvas>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="card" style="background-color: #eeeeee;">
              <div class="card-header card-header-icon card-header-info">
                <div class="card-icon">
                  <i class="material-icons">timeline</i>
                </div>
                <h4 class="card-title">Répartition des talibés
                  <!-- <small> - Rounded</small> -->
                </h4>
              </div>
              <div class="card-body">
                <canvas id="barchart"></canvas>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script type="text/javascript">

        var talibes = 0; 

        var myLabels = [] ;

        var myData =[] ;

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


 <script type="text/javascript">


        for(var i=0,l=myData.length; i < l ; i++ )
        {
          talibes += parseInt(myData[i]) ;
        }

        console.log(talibes);

        for(var i=0,l=myData.length; i < l ; i++ )
        {
          myLabels[i] += ' ('+ ((myData[i] / talibes ) * 100 ).toFixed(2) +' %) ' ;
        }


          var ctx = document.getElementById('pieChart');

          var data = {
        labels: myLabels,
        datasets: [{
            label: '# of Votes',
            data: myData,
            backgroundColor: myBackgroundColors,
            borderColor: myBackgroundColors,
            borderWidth: 2
        }]
    } ;

          var myPieChart = new Chart(ctx,{
          type: 'doughnut',
          data: data,
          options: {
         
            legend:{
              display:false
            }
          }
      });
  </script>
@endpush
