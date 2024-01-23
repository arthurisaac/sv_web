@extends('layouts.auth')

@section('content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Creer un compte!</h1>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="nom" class="form-label">{{ __('Nom') }}</label>
                            
                            <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror"
                            name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                            
                            @error('nom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom" class="form-label">{{ __('Prénom') }}</label>
                            
                            <input id="prenom" type="text"
                            class="form-control form-control-user @error('prenom') is-invalid @enderror" name="prenom"
                            value="{{ old('prenom') }}" required autocomplete="prenom" autofocus>
                            
                            @error('prenom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="telephone"
                            class="form-label">{{ __('N° Téléphone') }}</label>
                            
                            <input id="telephone" type="text"
                            class="form-control  form-control-user @error('telephone') is-invalid @enderror" name="telephone"
                            value="{{ old('telephone') }}" required autocomplete="telephone" autofocus>
                            
                            @error('telephone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email"
                            class="form-label">{{ __('Adresse Email') }}</label>
                            
                            <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                            
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password"
                            class="form-label">{{ __('Mot de passe') }}</label>
                            
                            <input id="password" type="password"
                            class="form-control form-control-user @error('password') is-invalid @enderror" name="password"
                            required autocomplete="new-password">
                            
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password-confirm"
                            class="form-label">{{ __('Confirmer le mot de passe') }}</label>
                            
                            <input id="password-confirm" type="password" class="form-control form-control-user"
                            name="password_confirmation" required autocomplete="new-password">
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">
                                {{ __('Enregistrer') }}
                            </button>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a class="small" href="{{ route('login') }}">Vous zavez déjà un compte? Connexion!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
