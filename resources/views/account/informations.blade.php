@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon profil</h1>
    <div class="row">
        <div class="col-xs-12">
            <p>Modification de mon profil</p>
            
            <form method="POST" action="{{ url('account/informations') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" placeholder="Adresse email" value="{{ old('email', $user->email) }}" name="email" />
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" placeholder="Mot de passe" name="password" />
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <label for="password_confirmation">Confirmation du mot de passe</label>
                    <input type="password" class="form-control" placeholder="Confirmation du mot de passe" name="password_confirmation" />
                    {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" placeholder="Prénom" value="{{ old('firstname', $user->firstname) }}" name="firstname" />
                    {!! $errors->first('firstname', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" value="{{ old('lastname', $user->lastname) }}" name="lastname" />
                    {!! $errors->first('lastname', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('birth_date') ? 'has-error' : '' }}">
                    <label for="birth_date">Date de naissance</label>
                    <input type="text" class="form-control" placeholder="Date de naissance" value="{{ old('birth_date', $user->birth_date) }}" name="birth_date" />
                    {!! $errors->first('birth_date', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('sex') ? 'has-error' : '' }}">
                    <label for="sex">Sexe</label>
                    <select class="form-control" name="sex">
                        <option>Sexe...</option>
                        <option value="1" {{ old('sex', $user->sex) == 1 ? 'selected' : '' }}>Homme</option>
                        <option value="2" {{ old('sex', $user->sex) == 2 ? 'selected' : '' }}>Femme</option>
                    </select>
                    {!! $errors->first('sex', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="text" class="form-control" placeholder="Numéro de téléphone" value="{{ old('phone', $user->phone) }}" name="phone" />
                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="1" name="newsletter" {{ old('newsletter', $user->newsletter) ? 'checked' : '' }} /> Newsletter
                    </label>
                </div>
                <button type="submit" class="btn btn-default">Sauvegarder</button>
            </form>

            <div>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
        </div>
    </div>
</div>
@endsection
