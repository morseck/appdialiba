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
				           		<div class="col-lg-4">
				           			<h3 class="card-title">{{ $talibe->fullname() }}</h3>
				            		<h4 class="category badge badge-success">{{ $talibe->daara != '' ? $talibe->daara->nom : 'non orienté' }}</h4>
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
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Dieuwrigne</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->dieuw != '' ? $talibe->dieuw->nom : ''  }}</div>
				             </div>
				             <div class="row mbt-15">
				             	<div class="col-lg-4 col-xs-6"><b>Niveau d'étude</b></div>
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->niveau }}</div>
				             </div><br>
				             <!--  <div class="row">
				             	<div class="col-lg-6 col-xs-6">{{ $talibe->commentaire }}</div>
				             </div><br> -->
				        </div>
				        <div class="card-footer">
				        	<div class="row">
				        		<div class="col-lg-6">
				        			<a class="btn btn-info" href="{{ route('talibe.edit',['id' => $talibe->id]) }}"><i class="fas fa-user-edit"></i> Editer</a>
				        		</div>
				        		<div class="col-lg-6">
				        			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deletmodal"><i class="fas fa-trash-alt"></i> Supprimer</button>
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



