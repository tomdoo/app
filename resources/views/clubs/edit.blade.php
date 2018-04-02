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
                <div class="form-group {{ $errors->has('access_code') ? 'has-error' : '' }}">
                    <label for="access_code">Code du club</label>
                    <input type="text" class="form-control" placeholder="Code du club" value="{{ old('access_code', $club->access_code) }}" name="access_code" />
                    {!! $errors->first('access_code', '<span class="help-block">:message</span>') !!}
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
