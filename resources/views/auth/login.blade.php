@extends('layouts.auth')

@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
            <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Content de te revoir!</h1>
                    </div>
                    <form class="user" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control  @error('email') is-invalid @enderror form-control-user"
                            id="exampleInputEmail" aria-describedby="emailHelp"
                            name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Entrer Addresse Mail...">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror form-control-user"
                            id="exampleInputPassword" placeholder="Mot de passe">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                <input type="checkbox" class="custom-control-input" id="rememberMe"
                                name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheck">Se rappeler de moi</label>
                            </div>
                        </div>
                        <button type="submit"  class="btn btn-primary btn-user btn-block">
                            Connexion
                        </button>
                        <hr>
                        <a href="#" class="btn btn-google btn-user btn-block">
                            <i class="fab fa-google fa-fw"></i> Connexion avec Google
                        </a>
                    </form>
                    <hr>
                    @if (Route::has('password.request'))
                    <div class="text-center">
                        <a class="small" href="{{ route('password.request') }}">Mot de passe oublié?</a>
                    </div>
                    @endif
                    <div class="text-center">
                        <a class="small" href="{{  route("register") }}">Creer un compte!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
