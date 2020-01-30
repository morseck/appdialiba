@extends('layouts.scratch',['title' => 'Liste des talibeList | '])

@section('content')
         <div class="container-fluid">
         	<div class="row">
			<h3 style="margin: auto;margin-bottom: 10px;"> Liste de tous les Talibes : [{{ $nbr }}]</h3>
		 </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card card-plain">
                  <div class="card-header card-header-icon card-header-success">
                    <div class="card-icon">
                      <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title mt-0"> Liste des Talibés</h4>
                    <p class="card-category">Cliquez sur le nom d'un talibé pour afficher plus de détails</p>
                    <a class="btn btn-success" style="float: right; padding-top: 1px; padding-bottom: 1px;padding-left: 3px;padding-right: 8px;" href="{{ route('talibe.create') }}"><i class="fas fa-user-plus"></i>Nouveau</a>
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
                          @foreach($talibeList as $talibe)
                          <tr>
                            <td><a href="{{ route('talibe.show',['id' => $talibe->id]) }}" title="Cliquez pour plus de détails">{{ $talibe->fullname() }}</a></td>
                            
                            <td>{{ $talibe->daara != '' ? $talibe->daara->nom : 'non orienté'}}</td>


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

                  <div class="card-footer">
                  	<p>{{ $talibeList->links() }}</p>
                  </div>

                </div>
              </div>          
            </div>
          </div>         
@endsection


@if( session()->has('talibeEvent')  )
  @push('scripts')

      <script type="text/javascript">
        (function(from, align) {
        type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

        color = Math.floor((Math.random() * 6) + 1);

        $.notify({
            icon: "notifications",
            message: "{{ session('talibeEvent') }}"

        }, {
            type: type[color],
            timer: 3000,
            placement: {
                from: from,
                align: align
            }
        });
    })();

      </script>

  @endpush
@endif
