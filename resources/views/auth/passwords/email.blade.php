@extends('layouts.app')

@section('content')
<div id="password-email">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell--span-12">
                <header class="center">
                    <a href="{{ route('home') }}"><img src="/img/logo-128.png" alt="{{ config('app.name') }}" /></a>
                    <h1>{{ config('app.name') }}</h1>
                </header>

                <p><strong>Mot de passe oublié</strong><br />Entrez votre adresse email pour définir un nouveau mot de passe.</p>

                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-text-field mdc-text-field--box mdc-text-field--with-trailing-icon {{ $errors->has('email') ? 'mdc-text-field--invalid' : '' }}">
                                <input type="email" id="email" name="email" class="mdc-text-field__input" required value="{{ old('email') }}"
                                    aria-controls="email-helper-text"
                                    aria-describedby="email-helper-text"
                                />
                                <label for="email" class="mdc-floating-label">Adresse email</label>
                                <i class="material-icons mdc-text-field__icon" tabindex="0" role="button">{{ $errors->has('email') ? 'error' : 'email' }}</i>
                                <div class="mdc-line-ripple"></div>
                            </div>
                            @if ($errors->has('email'))
                                <p id="email-helper-text" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg" aria-hidden="true">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="center">
                        <button type="submit" class="mdc-button mdc-button--unelevated">Réinitialiser mon mot de passe</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
