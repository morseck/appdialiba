 @if ($errors->any())
  <div class="alert alert-danger alert-with-icon" data-notify="container" style="width: 80%; text-align: center; margin: auto;">
  <i class="material-icons" data-notify="icon">notifications</i>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <i class="material-icons">close</i>
  </button>
  <span data-notify="message">

    @foreach ($errors->all() as $error)
      <p>{!! $error !!}</p>
    @endforeach

  </span>
  </div><br>
@endif