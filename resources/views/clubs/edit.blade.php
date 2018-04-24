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
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Nom du club</label>
                    <input type="text" class="form-control" placeholder="Nom du club" value="{{ old('name', $club->name) }}" name="name" />
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('club_type_id') ? 'has-error' : '' }}">
                    <label for="club_type_id">Type de club</label>
                    <select class="form-control" name="club_type_id">
                        <option>Type de club...</option>
                        @foreach ($clubTypes as $clubType)
                            <option value="{{ $clubType->id }}" {{ old('club_type_id', $club->club_type_id) == 1 ? 'selected' : '' }}>{{ $clubType->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('club_type_id', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description">Description</label>
                    <textarea type="text" class="form-control" placeholder="Description" name="description">{{ old('description', $club->description) }}</textarea>
                    {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('owner_alias') ? 'has-error' : '' }}">
                    <label for="owner_alias">Nom de responsable</label>
                    <input type="text" class="form-control" placeholder="Nom du responsable" value="{{ old('owner_alias', $club->owner_alias) }}" name="owner_alias" />
                    {!! $errors->first('owner_alias', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address">Adresse</label>
                    <textarea type="text" class="form-control" placeholder="Adresse" name="address">{{ old('address', $club->address) }}</textarea>
                    {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('postcode') ? 'has-error' : '' }}">
                    <label for="postcode">Code postal</label>
                    <input type="text" class="form-control" placeholder="Code postal" value="{{ old('postcode', $club->postcode) }}" name="postcode" />
                    {!! $errors->first('postcode', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                    <label for="city">Ville</label>
                    <input type="text" class="form-control" placeholder="Ville" value="{{ old('city', $club->city) }}" name="city" />
                    {!! $errors->first('city', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                    <label for="country_id">Pays</label>
                    <select class="form-control" name="country_id">
                        <option>Pays...</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id', $club->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('country_id', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">Numéro de téléphone</label>
                    <input type="text" class="form-control" placeholder="Numéro de téléphone" value="{{ old('phone', $club->phone) }}" name="phone" />
                    {!! $errors->first('phone', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('access_code') ? 'has-error' : '' }}">
                    <label for="access_code">Code du club</label>
                    <input type="text" class="form-control" placeholder="Code du club" value="{{ old('access_code', $club->access_code) }}" name="access_code" />
                    {!! $errors->first('access_code', '<span class="help-block">:message</span>') !!}
                </div>
                <button type="submit" class="btn btn-default btn-block">Sauvegarder</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
        </div>
    </div>
</div>
@endsection
