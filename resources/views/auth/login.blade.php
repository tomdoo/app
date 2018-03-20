@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Se connecter</h1>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Adresse email</h2>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-xs-12 control-label">Adresse email</label>
                            <div class="col-xs-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Adresse email" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-xs-12 control-label">Mot de passe</label>
                            <div class="col-xs-12">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Mot de passe" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Se connecter</button>
                                <a class="btn btn-default btn-md btn-block" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">Réseaux sociaux</h2>
                </div>
                <div class="panel-body">
                    <a href="{{ url('/auth/google') }}" class="btn btn-default btn-lg btn-block"><i class="fa fa-google"></i> Google</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
