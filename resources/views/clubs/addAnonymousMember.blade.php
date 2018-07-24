@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $club->name }}</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3>Ajouter un membre</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('firstname') ? 'has-error' : '' }}">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" placeholder="Prénom" value="{{ old('firstname') }}" name="firstname" />
                    {!! $errors->first('firstname', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" placeholder="Nom" value="{{ old('lastname') }}" name="lastname" />
                    {!! $errors->first('lastname', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="text" class="form-control" placeholder="Numéro de téléphone" value="{{ old('phone') }}" name="phone" />
                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" placeholder="Adresse email" value="{{ old('email') }}" name="email" />
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                <button type="submit" class="btn btn-default btn-block">Sauvegarder</button>
            </form>
        </div>
    </div>
</div>
@endsection
