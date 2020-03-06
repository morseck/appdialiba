@extends('layouts.app')

@section('content')
    <div class="page-header clear-filter" filter-color="orange">
        <div class="page-header-image" style="background-image: url('../assets/img/bg_talibe_1.jpg');"></div>
        <div class="content-center">
            <div class="col-md-5 ml-auto mr-auto">
                CONNECTEZ-VOUS POUR CONTINUER  <i class="fas fa-lock fa-lg"></i>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Connexion</h4>
                        <p class="category">Veuillez svp vous identifier</p>
                    </div><br>
               {{-- <div class="card-header">{{ __('Login') }}</div>--}}

                    <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            {{--<label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Adresse email" required autofocus>
                        </div>
                        <br>
                        <div class="form-group">
                            {{--<label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Mot de passe" required>
                        </div>
                        <br>
                        @if ($errors->has('email') || $errors->has('password'))
                            <span role="alert" class="text-danger">
                                <strong>L'adresse email ou le mot de passe est incorrect.</strong>
                            </span>
                        @endif
                        <div class="form-group ">
                                <button type="submit" class="btn btn-success">
                                   Connexion
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Mot de passe oublié ?
                                </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


