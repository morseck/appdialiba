@extends('layouts.scratch',['title' => 'Galerie | '])

@section('content')
	<div class="row">
		<div class="col-lg-10" style="margin: auto; text-align:center;">
			<div class="row">
				@foreach($talibes as $talibe)
				<div class="col-md-4">
					<a href="{{ route('talibe.show',['id' => $talibe->id]) }}">
						<figure style="margin-bottom: 40px;text-align:center;">

                            @if(($talibe->avatar !='') && (($talibe->avatar !='image talibe') && $talibe->avatar !='user_male.ico') && $talibe->avatar !='user_female.ico')
                                <img src="{{ asset('myfiles/talibe/'.$talibe->avatar) }}"
                                     style="width:55%; height: 170px; border-radius: 50%;margin-bottom: 20px;"
                                     title="{{ $talibe->fullname() }}">
                            @else
                                <img src="{{ asset('assets/img/default-avatar.png') }}"
                                     style="width:55%; height: 170px; border-radius: 50%;margin-bottom: 20px;"
                                     title="{{ $talibe->fullname() }}">
                            @endif
							<figcaption style="background-color: #4CAF50; color:white;
							border-radius:5px;font-weight:bold; width: 70%; margin:auto;">
								{{ $talibe->fullname() }}
							</figcaption>
						</figure>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="row" style="text-align:center; margin-top: 30px;">
		<div class="col-lg-4" style="margin: auto; text-align:center;">
		<p> {{ $talibes->links() }} <p>
		</div>
	</div>
@endsection
