@extends('layouts.scratch',['title' => 'Modifier d\'un ordonnance | '])

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


@push('styles')
    <style type="text/css">
        label{
            color: black !important;
        }
        .bootstrap-select>.dropdown-toggle{
            width: 114% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush


@section('content')
    <div class="container-fluid">
        <div class="col-md-8 col-12 mr-auto ml-auto">
            <div class="wizard-container">
                <div class="card card-wizard" data-color="green" id="wizardProfile">
                    <form action="{{ route('ordonnance.update',['id' => $ordonnance->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf()
                        {{ method_field('PUT')}}
                        <!--        You can switch " data-color="primary" "  with one of the next bright colors: "green", "orange", "red", "blue"       -->
                        <div class="card-header text-center">
                            <h4 class="card-title">Ordornnance </h4>
                        </div>
                        @include('partials.errors')
                        <div class="wizard-navigation">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#about" data-toggle="tab" role="tab">
                                        Modifier ordonnance
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">

                            <div class="tab-content"><div class="tab-pane active" id="about">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-10">
                                            <div class="picture-container">
                                                <img src="{{ asset('myfiles/ordonnances/'.$ordonnance->file_ordonnance) }}" class="picture-src" id="wizardPicturePreview" title="" />

                                                <div class="picture">
                                                    @if(($ordonnance->talibe->avatar!='') && ($ordonnance->talibe->avatar !='image medecin'))
                                                        <img style="width: 100%" src="{{ asset('myfiles/talibe/'.$ordonnance->talibe->avatar) }}" title="" />
                                                    @else
                                                        <img src="{{ asset('assets/img/default-avatar.png') }}" class="picture-src" id="" title="" />
                                                    @endif
                                                    <input type="file" id="wizard-picture" name="file_ordonnance">
                                                </div>
                                                <h6 class="category">{{$ordonnance->talibe->fullName()}}</h6>
                                                <p class="category">{{$ordonnance->talibe->daara->nom}}</p>
                                            </div>
                                        </div>


                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-md"></i>
                                                    </span>
                                                        </div>
                                                        <div class="form-group">
                                                            <select class="selectpicker" data-style="select-with-transition" title="Medecin" name="medecin_id" >
                                                                @foreach($medecins as $medecin)
                                                                    <option value="{{ old('medecin_id') ?? $medecin->id}}" {{ $medecin->id == $ordonnance->medecin_id ? 'selected' : ''}}>{{old('medecin_id') ?? $medecin->fullName()}}</option>
                                                                @endforeach
                                                                <option {{ $ordonnance->id == null ? 'selected' : ''}}>Autre</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="input-group form-control-lg">
                                                        <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-hospital"></i>
                                                    </span>
                                                        </div>
                                                        <div class="form-group">
                                                            <select class="selectpicker" data-style="select-with-transition" title="Hôpital" name="nom_hopital" >
                                                                @foreach($hopitals as $hopital)
                                                                    <option value="{{ old('nom_hopital') ?? $hopital->nom}}" {{ $hopital->nom == $ordonnance->nom_hopital ? 'selected' : ''}}>
                                                                        {{ old('nom_hopital') ?? $hopital->nom }}
                                                                    </option>
                                                                @endforeach
                                                                <option {{ $hopital->nom == null ? 'selected' : ''}}>Autre</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                      <i class="fas fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInput11" class="bmd-label-floating">Date ordonnance</label>
                                                    <input type="text" class="form-control" name="date_ordonnance" id="datenaissance" value="{{ old('date_ordonnance') ?? app_date_reverse($ordonnance->date_ordonnance,'-','/') }}"  style="background-color: transparent;">
                                                </div>
                                            </div>
                                            <div class="input-group form-control-lg">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                 <i class="fas fa-stethoscope"></i>
                                                </span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInput11" class="bmd-label-floating">Avis</label>
                                                    <textarea class="form-control" name="commentaire" style="background-color: transparent;">{{ (old('commentaire')) ?? $ordonnance->commentaire }}</textarea>
                                                </div>
                                            </div>
                                        </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="ml-auto">
                                    <input type="submit" class="btn btn-finish btn-fill btn-success btn-wd" name="finish" value="Valider" style="display: none;">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                    </form>
                </div>
            </div>
            <!-- wizard container -->
        </div>
    </div>
@endsection
@push('scripts-scroll')
    <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
    <script type="text/javascript">

        $(document).ready(function() {
            //init DateTimePickers
            md.initFormExtendedDatetimepickers();

            // Initialise the wizard
            demo.initMaterialWizard();
            setTimeout(function() {
                $('.card.card-wizard').addClass('active');
            }, 200);
        });

        // Initialise the datepicker
        let dateOpt = {dateFormat: "d/m/Y", locale: 'fr'};

        $('#arrivee').flatpickr(dateOpt);
        $('#datenaissance').flatpickr(dateOpt);


    </script>

    @if( session()->has('medecinEvent')  )
        <script type="text/javascript">
            (function(from, align) {
                //type = ['', 'info', 'success', 'warning', 'danger', 'rose', 'primary'];

                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                    icon: "notifications",
                    message: "{{ session('medecinEvent') }}"

                }, {
                    //type: type[color],
                    type: 'success',
                    timer: 3000,
                    placement: {
                        from: from,
                        align: align
                    }
                });
            })();

        </script>

    @endif

@endpush
