@extends('layouts.scratch', ['title' => 'Liste des Talibes du Daara '.$dname.' |'])

@section('content')
         <div class="container-fluid">
         	<div class="row">
			<h3 style="margin: auto;margin-bottom: 10px;"> Liste des Talibes de  {{ $dname }} : ({{ $talibes->count() }})</h3>
		 </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-plain">
                  <div class="card-header card-header-icon card-header-success">
                    <div class="card-icon">
                      <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title mt-0"> Liste des Entreprises Partenaires</h4>
                    <p class="card-category">Cliquez sur le nom d'un partenaire pour afficher plus de détails</p>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table">
                        <thead class="text-primary">
                          <th>Nom</th>
                          <th>Daara</th>
                          <th>Dieuwrigne</th>
                          <th>Téléphone</th>
                          <th>Tuteur</th>
                        </thead>

                        <tbody>
                          @foreach($talibes as $talibe)
                          <tr>
                            <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour plus de détails">{{ $talibe->fullname() }}</a></td>
                            <td>{{ $dname }}</td>
                            <td> 
                            @if($talibe->dieuw)
                            	{{ $talibe->dieuw->fullname() }}
                            @endif
                            </td>
                            <td>
                              <a href="#" title="Cliquer pour envoyer un mail">{{ $talibe->phone1 }}</a>
                            </td>
                            <td> {{ $talibe->tuteur }} </td>
                          </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>          
            </div>
          </div>         
@endsection





