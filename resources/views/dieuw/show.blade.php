@extends('layouts.scratch',['title' => 'Profil de '.$dieuw->fullname().' | '])

@section('content')

	<div class="container-fluid">
		<div class="row">				              
            <div class="col-lg-5 col-xs-12" >
            	<div class="row">
            		<div class="col-md-12">
				    <div class="card">
				        <div class="card-header">
				           <div class="row">
				           		<div class="col-lg-6">
				           			<h3 class="card-title">{{ $dieuw->fullname() }}</h3>
                                    <a href="{{ route('by_daara',['id' => $dieuw->daara->id]) }}"><h4 class="category badge badge-success">{{ $dieuw->daara != '' ? $dieuw->daara->nom : 'non orienté' }}</h4></a>
                                    <a href="{{ route('by_dieuw',['id' => $dieuw->id]) }}"><h4 class="category badge badge-warning pull-right">{{ $total}} Talibés</h4></a>
				           		</div>
				           		<div class="col-lg-6">
				           			<img src="{{ asset('storage/dieuws/'.$dieuw->avatar) }}" style="width: 75px; height: 75px; border-radius: 50%;">
				           		</div>
				           </div>
				        </div>
				        <div class="card-body">
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Genre</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ intval($dieuw->genre) === 1 ? 'Masculin': 'Féminin' }}</div>
				             </div>
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Père</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->pere }}</div>
				             </div>
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Mère</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->mere }}</div>
				             </div>
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Tuteur</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->tuteur }}</div>
				             </div>

				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Phone 1</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->phone1 }}</div>
				             </div>
				              <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Phone 2</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->phone2 }}</div>
				             </div>
				              <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Adresse</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->adresse }}</div>
				             </div>
				              <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Région</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->region }}</div>
				             </div>
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Date de naissance</b></div>
			             	<div class="col-lg-6 col-xs-6">{{ app_date_reverse($dieuw->datenaissance,'-','-') }}</div>
				             </div>
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Lieu de naissance</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $dieuw->lieunaissance }}</div>
				             </div>
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Date d'arrivée</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ app_date_reverse($dieuw->arrivee,'-','-') }}</div>
				             </div>
				            @if($dieuw->depart)
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Date de départ</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ app_date_reverse($dieuw->depart,'-','-') }}</div>
				             </div>
				            @endif
				            @if($dieuw->deces)
				             <div class="row">
				             	<div class="col-lg-4 col-xs-6"><b>Date de décès</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ app_date_reverse($dieuw->deces,'-','-') }}</div>
				             </div>
				             @endif
				        </div>
				        <div class="card-footer">
				        	<div class="row">
				        		<div class="col-lg-6">
				        			<a class="btn btn-info btn-sm" href="{{ route('dieuw.edit',['id' => $dieuw->id]) }}"><i class="fas fa-user-edit"></i> Editer</a>
				        		</div>
				        		<div class="col-lg-6">
				        			<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletmodal"><i class="fas fa-trash-alt"></i> Supprimer</button>
				        		</div>
				        	</div>
				        </div>
				    </div>
				  </div>
            	</div>
           </div>
            <div class="col-lg-7 col-xs-12" >
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">insert_chart</i>
                                </div>
                                <h4 class="card-title mt-10"> <strong>Statistique Dieuwrine</strong></h4>
                            </div>
                            <div class="card-body">
                                <div class="card-header card-header-warning card-header-icon">
                                    <h4 class="card-title mt-10" style="margin-bottom: 20px;"><strong>Diagramme en barre horizontale</strong> Répartitions en fonction des Hizibs</h4>
                                </div>
                                <canvas id="myChart1"></canvas>
                            </div>
                           {{-- <div class="card-body">
                                <div class="card-header card-header-warning card-header-icon">
                                    <h4 class="card-title mt-10"> </h4>
                                </div>
                                <canvas id="myChart2"></canvas>
                            </div>--}}
                        </div>
                    </div>
                   {{-- <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                    <i class="material-icons">insert_chart</i>
                                </div>
                                <h4 class="card-title mt-10"> Statistique Dieuwrine</h4>
                            </div>
                            <div class="card-body">
                                --}}{{--<canvas id="myChart2"></canvas>--}}{{--
                            </div>
                        </div>
                </div>--}}
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
			      <form action="{{ route('dieuw.destroy',['id' => $dieuw->id ]) }}" method="post">
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
    {{--Diagramme--}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script>
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
        myLabels.push('<?= $part->niveau ?>') ;
        myData.push('{{ $part->poids }}');
        myBackgroundColors.push(randomColor()) ;
    </script>
    <?php endforeach; ?>
    {{--Omar--}}
    <script type="text/javascript">


        for(var i=0,l=myData.length; i < l ; i++ )
        {
            talibes += parseInt(myData[i]) ;
        }

        console.log(talibes);

        for(var i=0,l=myData.length; i < l ; i++ )
        {
            myLabels[i] += ' ('+ ((myData[i] / talibes ) * 100 ).toFixed(2) +' %)'+'  ['+myData[i]+']' ;
        }

        myData.push(0);
        var ctx1 = document.getElementById('myChart1');
        var ctx2 = document.getElementById('myChart2');
        // var ctx3 = document.getElementById('myChart3');

        var data = {
            labels: myLabels,
            datasets: [{
                label: '# of Votes',
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

        var myChart1 = new Chart(ctx1,{
            type: 'horizontalBar',
            data: data,
            options: {
                legend:{
                    display:false
                }
            }
        });

        var myChart2 = new Chart(ctx2,{
            type: 'doughnut',
            data: data,
            options: {

                legend:{
                    display:false
                }
            }
        });

        /* var myChart3 = new Chart(ctx3,{
             type: 'bar',
             data: data,
             options: {

                 legend:{
                     display:false
                 }
             }
         });*/

    </script>
@endpush


