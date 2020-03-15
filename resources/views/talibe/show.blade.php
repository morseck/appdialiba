@extends('layouts.scratch',['title' => 'Profil de '.$talibe->fullname().' | '])


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

@section('content')

	<div class="container-fluid">
		<div class="row">				              
            <div class="col-lg-7 col-xs-8" style="margin: auto;">
            	<div class="row">
            		<div class="col-md-12">
				    <div class="card">
				        <div class="card-header">
				           <div class="row">
				           		<div class="col-lg-6">
				           			<h3 class="card-title">{{ ucfirst(strtolower($talibe->prenom))}} <strong><b>{{ strtoupper($talibe->nom) }}</b></strong></h3>
                                    @if($talibe->daara != '' )
                                        <a href="{{ route('by_daara',['id' => $talibe->daara->id]) }}" title="Cliquer pour voire les détails sur le Daara" ><h4 class="category badge badge-success">{{ $talibe->daara->nom  }}</h4></a>
                                    @else
                                        <span class="category badge badge-warning">non orienté</span>
                                    @endif
                                </div>
				           		<div class="col-lg-6">
				           			<img src="{{ asset('storage/talibes/'.$talibe->avatar) }}" style="width:100px; height: 100px; border-radius: 50%;">
				           		</div>
				           </div>
				        </div>
				        <div class="card-body">
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Genre</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ intval($talibe->genre) === 1 ? 'Masculin': 'Féminin' }}</div>
				             </div>
                            <div class="row mbt-15">
                                <div class="col-lg-4 col-xs-6"><b>Niveau d'étude</b></div>
                                <div class="col-lg-6 col-xs-6"><strong><b>{{ $talibe->niveau }}</b></strong></div>
                            </div>
                            <div class="row mbt-15">
                                <div class="col-lg-4 col-xs-6"><b>Dieuwrigne</b></div>
                                <div class="col-lg-6 col-xs-6">
                                    @if($talibe->dieuw != '')
                                        <a href="{{ route('dieuw.show',['id' =>  $talibe->dieuw->id]) }}" title="Cliquer pour voire les détails sur le Dieuwrine" class="category badge badge-default text-white">{{ $talibe->dieuw->fullname() }}</a>
                                    @else
                                        <span class="category badge badge-danger">non affecté</span>
                                    @endif
                                </div>
                            </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Père</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->pere }}</div>
				             </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Mère</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->mere }}</div>
				             </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Tuteur</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->tuteur }}</div>
				             </div>

				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Phone 1</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->phone1 }}</div>
				             </div>
				              <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Phone 2</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->phone2 }}</div>
				             </div>
				              <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Adresse</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->adresse }}</div>
				             </div>
				              <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Région</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->region }}</div>
				             </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Date de naissance</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ app_date_reverse($talibe->datenaissance,'-','-') }}</div>
				             </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Lieu de naissance</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->lieunaissance }}</div>
				             </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Date d'arrivée</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ app_date_reverse($talibe->arrivee,'-','-') }}</div>
				             </div>
				             @if($talibe->depart)
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Date de départ</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->depart }}</div>
				             </div>
				             @endif
				             @if($talibe->depart)
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Date de décès</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->deces }}</div>
				             </div>
				             @endif
				             <br>
				             <!--  <div class="row">
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->commentaire }}</div>
				             </div><br> -->
				        </div>
				        <div class="card-footer">
				        	<div class="row">
				        		<div class="col-lg-4">
				        			<a class="btn btn-info" href="{{ route('talibe.edit',['id' => $talibe->id]) }}"><i class="fas fa-user-edit"></i> Editer</a>
				        		</div>
				        		<div class="col-lg-4">
				        			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletmodal"><i class="fas fa-trash-alt"></i> Supprimer</button>
				        		</div>
                                <div class="col-lg-4">
                                    <a class="btn btn-default" href="{{ route('talibe.index') }}"><i class="fas fa-list"></i> Liste Talibés</a>
                                </div>
				        	</div>
				        </div>
				    </div>
				  </div>
            	</div>
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
			      <form action="{{ route('talibe.destroy',['id' => $talibe->id ]) }}" method="post">
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



