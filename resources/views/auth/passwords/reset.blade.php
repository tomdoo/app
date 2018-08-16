@extends('layouts.app')

@section('content')
<div id="password-reset">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell--span-12">
                <header class="center">
                    <a href="{{ route('home') }}"><img src="/img/logo-128.png" alt="{{ config('app.name') }}" /></a>
                    <h1>{{ config('app.name') }}</h1>
                </header>

                <p><strong>Réinitialisation du mot de passe</strong><br />Entrez votre adresse email et votre nouveau mot de passe.</p>

                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-text-field mdc-text-field--box mdc-text-field--with-trailing-icon {{ $errors->has('email') ? 'mdc-text-field--invalid' : '' }}">
                                <input type="email" id="email" name="email" class="mdc-text-field__input" required value="{{ $email or old('email') }}"
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

                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-text-field mdc-text-field--box mdc-text-field--with-trailing-icon {{ $errors->has('password') ? 'mdc-text-field--invalid' : '' }}">
                                <input type="password" id="password" name="password" class="mdc-text-field__input" required
                                    aria-controls="password-helper-text"
                                    aria-describedby="password-helper-text"
                                />
                                <label for="password" class="mdc-floating-label">Mot de passe</label>
                                <i class="material-icons mdc-text-field__icon" tabindex="0" role="button">{{ $errors->has('password') ? 'error' : 'lock' }}</i>
                                <div class="mdc-line-ripple"></div>
                            </div>
                            @if ($errors->has('password'))
                                <p id="password-helper-text" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent mdc-text-field-helper-text--validation-msg" aria-hidden="true">
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mdc-layout-grid__inner">
                        <div class="mdc-layout-grid__cell--span-12">
                            <div class="mdc-text-field mdc-text-field--box mdc-text-field--with-trailing-icon">
                                <input type="password" id="password-confirm" name="password_confirmation" class="mdc-text-field__input" required />
                                <label for="password" class="mdc-floating-label">Confirmation du mot de passe</label>
                                <i class="material-icons mdc-text-field__icon" tabindex="0" role="button">lock</i>
                                <div class="mdc-line-ripple"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="center">
                        <button type="submit" class="mdc-button mdc-button--unelevated">Valider mon nouveau mot de passe</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
