@extends('layouts.scratch', ['title' => 'Liste des Talibes du Daara '.$dname.' |'])

@section('content')

	<div class="container-fluid">
		<div class="row">
			<h3 style="margin: auto;margin-bottom: 10px;"> Liste des Talibes de  {{ $dname }} : ({{ $talibes->count() }})</h3>
		</div>
		<div class="row">				              
                <div class="col-lg-10" style="margin: auto;">
                	<div class="row">
                		@foreach($talibes as $talibe)
                    <div class="col-md-6">
                    <div class="card" style="background-color:#eeeeee;">
                      <div class="card-header">
                        <h4 class="card-title">{{ $talibe->fullname() }} &emsp; 
                          <a href="{{ route('talibe.edit',['id' => $talibe->id]) }}" title="Editer le profil" class="text-primary btn btn-link btn-sm"><i class="material-icons ">update</i></a>
                          <a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Supprimer" class="text-danger btn btn-link btn-sm"><i class="material-icons">delete_sweep</i></a>
                        </h4>
                        <p class="category">{{ is_null($talibe->daara) ? 'Non Orienté' : $talibe->daara->nom }}</p>
                        
                      </div>
                      <div class="card-body" style="line-height: 80%;margin-top: -15px;">
                        <div class="row">
                            <div class="col-md-5">
                              <img src="{{ asset('assets/img/default-avatar.png') }}" style="width: 115px; height: 115px; border-radius: 50%;">
                            </div>
                            <div class="col-md-7" style="margin-top: 15px;">
                               <p>Phone :  {{ $talibe->phone1 }}</p>
                               <p>Tuteur : <span class="badge badge-pill badge-primary">{{ $talibe->tuteur }}</span></p>

                               @if( $talibe->dieuw)
                               <p>Dieuw : <a href="{{ route('dieuw.show',['id'=> $talibe->dieuw->id ]) }}">{{ $talibe->dieuw->fullname() }}</a></p>
                               @endif
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
                	</div>
                	
               </div>
		</div>
	</div>

@endsection