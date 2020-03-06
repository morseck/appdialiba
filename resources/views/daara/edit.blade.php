@extends('layouts.scratch',['title' => 'Edition daara |'])

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush


@section('content')
<div class="container-fluid"> 
              <div class="row">
                <div class="col-lg-6 card" style="margin: auto;">
                  <div class="card" data-color="purple" {{--style="background-color:#eeeeee;"--}}>
                   
                  <form class="form-horizontal" method="POST" action="{{ route('daara.update',['id' => $daara->id]) }}" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  {{ method_field('PUT') }}
                  <div class="card-header text-center">
                      <h4 class="card-title" style="margin-top: 20px;">EDITION <span style="color: #47A44B;font-weight: 400;font-size:0.8em;">{{ $daara->nom }}</span></h4>
                  </div>

                  @include('partials.errors')  

                  <div class="card-body">

                     <div class="row">
                          <span class="col-md-4 col-form-label">Nom Daara </span>
                          <div class="col-md-8">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" name="nom" value="{{ old('nom') ?? $daara->nom }}" required>
                            </div>
                          </div>
                        </div><br>

                      <div class="row">
                          <span class="col-md-4 col-form-label">Dieuwrigne</span>
                          <div class="col-md-8">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" name="dieuw" value="{{ old('dieuw') ?? $daara->dieuw }}" required>
                            </div>
                          </div>
                        </div><br>


                        <div class="row">
                          <span class="col-md-4 col-form-label">Téléphone</span>
                          <div class="col-md-8">
                            <div class="form-group has-default">
                              <input type="text" class="form-control" name="phone" value="{{ old('phone') ?? $daara->phone }}" minlength="9" required>
                            </div>
                          </div>
                        </div><br>

                        <div class="row">
                          <span class="col-md-4 col-form-label">Image</span>
                          <div class="col-md-8">
                              <div class="form-group">
                                <div class="fileinput fileinput-new text-center" data-provides="fileinput" style="width: 100%;"> 
                                  <label class="btn btn-round btn-success btn-file btn-block" for="input-file">
                                    <span id="filename">Joindre le contrat pdf</span>
                                    <input type="file"  class="form-control" name="image" id="input-file"  />
                                  </label>
                              </div>
                              </div>
                            
                          </div>
                        </div><br>

                         <div class="row">
                            <span class="col-md-4 col-form-label">Création</span>

                            <div class="col-md-8">    
                                <input type="text" name="creation" id="creation" class="form-control" style="background-color: transparent;"
                                value="{{ app_date_reverse($daara->creation,'-','/') ?? old('creation') }}">
                            </div>
                        </div><br>

                        <div class="row">
                            <span class="col-md-4 col-form-label">Latitude</span>
                            <div class="col-md-8">    
                                <input type="text" name="lat" class="form-control" value="{{ $daara->lat ?? old('lat') }}">
                            </div>
                        </div><br>

                        <div class="row">
                            <span class="col-md-4 col-form-label">Longitude</span>
                            <div class="col-md-8">    
                                <input type="text" name="lon" class="form-control" value="{{ $daara->lon ?? old('lon') }}">
                            </div>
                        </div>

                  </div>

                  <dir class="card-footer">
                    <div class="container">
                        <div class="row">
                        <div class="col-lg-6 text-center"  style="margin: auto;margin-top: 3px;">
                              <button type="submit" class="btn btn-success" >Mettre à jour Daara</button>
                       </div>
                        </div>
                    </div>
                  </dir>
                        
                </form>
              
              </div>
                </div>
              </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/fr.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

      let dateOpt = {dateFormat: "d/m/Y", locale: 'fr'};

      $('#creation').flatpickr(dateOpt);

        $('#input-file').change(function(event) {

          var fileList = event.target.files;

          console.log(fileList);

        if (fileList.length) {
          $('#filename').text(fileList[0].name)
        }
     });
  });
     
</script>
@endpush
