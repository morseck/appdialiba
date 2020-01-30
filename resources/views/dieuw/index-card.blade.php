@extends('layouts.scratch',['title' => 'Liste des Dieuws | '])

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-10" style="margin: auto;">
				<a class="btn btn-success btn-sm" style="float: right;" href="{{ route('dieuw.create') }}"><i class="fas fa-user-plus"></i>&nbsp; Nouveau</a>
			</div>
		</div>
		<div class="row">				              
                <div class="col-lg-10" style="margin: auto;">
                	<div class="row">
                		@foreach($dieuws as $dieuw)
                    <div class="col-md-6">
                    <div class="card" style="background-color:#eeeeee;">
                      <div class="card-header">
                        <h4 class="card-title">{{ $dieuw->fullname() }} &emsp; 
                          <a href="{{ route('dieuw.edit',['id' => $dieuw->id]) }}" title="Editer le profil" class="text-primary btn btn-link btn-sm"><i class="fas fa-user-edit fa-2x"></i></a>
                          <a href="{{ route('dieuw.show',['id' => $dieuw->id]) }}" title="Supprimer" class="text-danger btn btn-link btn-sm"><i class="fas fa-trash-alt fa-2x"></i></a>
                        </h4>
                        <p class="category">{{ is_null($dieuw->daara) ? 'Non Orienté' : $dieuw->daara->nom }}</p>
                        
                      </div>
                      <div class="card-body" style="line-height: 80%;margin-top: -15px;">
                        <div class="row">
                            <div class="col-md-5">
                              <img src="{{ asset('assets/img/default-avatar.png') }}" style="width: 115px; height: 115px; border-radius: 50%;">
                            </div>
                            <div class="col-md-7" style="margin-top: 15px;">
                               <p>Phone :  {{ $dieuw->phone1 }}</p>
                               <p>Tuteur : <span class="badge badge-pill badge-primary">{{ $dieuw->tuteur }}</span></p>

                               @if( $dieuw->dieuw)
                               <p>Dieuw : <a href="{{ route('dieuw.show',['id'=> $dieuw->dieuw->id ]) }}">{{ $dieuw->dieuw->fullname() }}</a></p>
                               @endif
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                	</div>
                	<div class="well text-center">
                		{{  $dieuws->links() }}
                	</div>
               </div>
		</div>
	</div>

@endsection