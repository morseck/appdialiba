@extends('layouts.scratch',['title' => 'Liste des Daaras'])

@section('topbar')
<div class="row" style="padding-right: 6em;padding-top: 20px;">
  <a href="{{ route('daara.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Nouveau Daara</a>
</div>
@endsection('topbar')


@section('content')
<div class="container-fluid">
		<div class="row card">
            <div class="card-header card-header-primary card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">domain</i>
                </div>
                <h4 class="card-title mt-10"> Daaras</h4>
            </div>
                <div class="col-lg-10" style="margin: auto;">
                	<div class="row">
                		@foreach($daaraList as $daara)
                    <div class="col-md-6">
                    <div class="card" style="background-color:#eeeeee; border: 1px solid rgba(0,0,0,0.2);">
                      <div class="card-header">
                        <h4 class="card-title"><strong> <a href="{{ route('by_daara',['id' => $daara->id]) }}">{{ $daara->nom }} </a></strong> &emsp;
                          <a href="{{ route('daara.edit',['id' => $daara->id]) }}" title="Editer le profil" class="text-primary btn btn-outline-success btn-sm">&nbsp;Editer</a>
                          <!-- <a href="{{ route('daara.show',['id' => $daara->id]) }}" title="Supprimer" class="text-danger btn btn-link btn-sm"><i class="material-icons">delete_sweep</i></a> -->
                        </h4>
                        <p class="category">
                            <a href="{{ route('by_daara',['id' => $daara->id]) }}" style="color: black;">
                                <b>{{ $daara->talibes->count() }}</b> Talibés &emsp;
                                <b>{{ $daara->dieuws->count() }}</b> Serignes Daaras &emsp;
                                <b>{{ $daara->tarbiyas->count() }}</b> Ndongos Tarbiya

                            </a> &emsp;
                            <b>
                                {{ app_date_reverse($daara->creation,'-','/')}}
                            </b>
                        </p>


                      </div>
                      <div class="card-body" style="line-height: 80%;margin-top: -15px;">
                        <div class="row">
                            <div class="col-md-5">
                                @if($daara->image == null || $daara->image == "")
                                    <img src="{{ asset('assets/img/touba.jpg') }}" style="width: 120px; height: 115px; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('myfiles/daara/'.$daara->image) }}" style="width: 120px; height: 115px; border-radius: 50%;">
                                @endif
                            </div>
                            <div class="col-md-7" style="margin-top: 15px;">
                               <p>Phone :  {{ $daara->phone }}</p>
                               <p>Dieuwrigne : <span class="badge badge-pill badge-success">{{ $daara->dieuw }}</span></p>
                               <p>Localisation : <a href="" title="Voir dans Maps">{{ $daara->location() }}</a></p>

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

@endsection('content')


@if( session()->has('daaraEvent')  )
  @push('scripts')

      <script type="text/javascript">
        (function(from, align) {
        type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

        color = Math.floor((Math.random() * 6) + 1);

        $.notify({
            icon: "notifications",
            message: "{{ session('daaraEvent') }}"

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



