@extends('layouts.scratch',['title' => 'Galerie | '])
@push('styles')
    <style type="text/css">
        div b {
            font-size: 1.1em;
        }

        .mbt-15 {
            margin-bottom: 7px;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/drift-zoom/1.3.1/drift-basic.min.css" integrity="sha512-us5Qz8z1MIzLykX5KtvnVAcomNfU28BC7wdaZS2QICFxgJo4QoLj6OXq/FeAl+qb+qyqsxilHoiMBgprdnKtlA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
	<div class="row">
		<div class="col-lg-10" style="margin: auto; text-align:center;">
			<div class="row">
<!--                <div class="col-md-8 position-absolute" id="imgDetails" style="width: 100%; height: 100%; z-index: 3; display: none">
                    <p>

                    </p>
                </div>-->
				@foreach($talibes as $talibe)
				<div class="col-md-4" id="zoomSelector">
					<a href="{{ route('talibe.show',['id' => $talibe->id]) }}">
						<figure style="
						            padding-top: 15px;
						            padding-bottom: 15px;
						            position: center;
						            border-radius: 15px;
						            background: #ffffff;
                        ">
                            @if(($talibe->avatar !='') && (($talibe->avatar !='image talibe') && $talibe->avatar !='user_male.ico') && $talibe->avatar !='user_female.ico')
                                <img src="{{ asset('myfiles/talibe/'.$talibe->avatar) }}"
                                     onmouseover="zoomImage('{{asset('assets/img/default-avatar.png')}}', '{{ $talibe->nom }}');"
                                     data-zoom="{{ asset('myfiles/talibe/'.$talibe->avatar) }}"
                                     id="{{ $talibe->nom }}"
                                     style="width:55%; height: 170px; border-radius: 50%;margin-bottom: 20px;"
                                     title="{{ fullName($talibe->prenom, $talibe->nom) }}">
                            @else
                                <img src="{{ asset('assets/img/default-avatar.png') }}"
                                     onmouseover="zoomImage('{{asset('assets/img/default-avatar.png')}}', '{{ $talibe->nom }}');"
                                     data-zoom="{{ asset('assets/img/default-avatar.png') }}"
                                     id="{{ $talibe->nom }}"
                                     style="width:55%; height: 170px; border-radius: 50%;margin-bottom: 20px;"
                                     title="{{ fullName($talibe->prenom, $talibe->nom) }}">
                            @endif
							<figcaption style="background-color: #4CAF50; color:white;
							border-radius:5px;font-weight:bold; width: 90%; margin: auto">
								{{ fullName($talibe->prenom, $talibe->nom) }}
							</figcaption>
                            <span class="tag">
                                <a href="{{ route('by_daara',['id' => $talibe->daara_id]) }}" title="Cliquez pour voir les détails sur le daaras">
                                    <span  style="font-size: small">
                                        <span class="btn btn-outline-info category badge badge-pill">
                                            <i class="fas fa-home mr-1"></i>
                                            {{$talibe->daara_nom}}
                                        </span>
                                   </span>
                                </a>
                            </span>
                            <span class="tag">
                                    <a href="{{ route('dieuw.show',['id' =>  $talibe->dieuw_id]) }}" title="Cliquez pour voir les détails sur le dieuwrine">
                                        <span  style="font-size: small">
                                            <span class="btn btn-outline-warning category badge badge-pill">
                                                <i class="fas fa-user-graduate mr-1"></i>
                                                {{fullName($talibe->dieuw_prenom, $talibe->dieuw_nom)}}
                                            </span>
                                       </span>
                                    </a>
                                </span>
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
@push('scripts-scroll')
    <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/drift-zoom/1.3.1/Drift.min.js" integrity="sha512-Pd9pNKoNtEB70QRXTvNWLO5kqcL9zK88R4SIvThaMcQRC3g8ilKFNQawEr+PSyMtf/JTjV7pbFOFnkVdr0zKvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>

        function zoomImage(image, id) {
            console.log("image:", image)
            console.log("id:", id)
            if (image && id){
                id = id.toLocaleString()
                const drift = new Drift(document.querySelector("#"+id.toString()), {
                    paneContainer: document.querySelector("#imgDetails")
                });

                console.log("before drift: ", drift)
            }

        }
    </script>
@endpush
