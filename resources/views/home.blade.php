@extends('layouts.app')

@section('content')
<div id="home">
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell--span-12">
                <header class="center">
                    <a href="{{ route('home') }}"><img src="/img/logo-128.png" alt="{{ config('app.name') }}" /></a>
                    <h1>{{ config('app.name') }}</h1>
                </header>
                
                <p><strong>Bienvenue</strong><br />Plus que quelques étapes avant de nous rejoindre.</p>
                
                <div class="social center">
                    <a href="{{ url('/auth/google') }}" class="mdc-button mdc-button--unelevated"><i class="fab fa-google-plus-g"></i>&nbsp;Continuer avec Google</a><br />
                </div>
                
                <div class="separator">
                    <span class="separator-text">Ou</span>
                </div>
                
                <div class="center">
                    <a class="mdc-button mdc-button--outlined" href="{{ route('register') }}">
                        <i class="material-icons">email</i>&nbsp;S'inscrire avec une adresse email
                    </a>
                </div>
                
                <div class="login center">
                    Vous êtes déjà membre ? <strong><a href="{{ route('login') }}">Se connecter</a></strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
