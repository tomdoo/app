@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <h2>Nouveau club</h2>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ url('clubs/create') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Nom du club</label>
                    <input type="text" class="form-control" placeholder="Nom du club" value="{{ old('name') }}" name="name" />
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('club_type_id') ? 'has-error' : '' }}">
                    <label for="club_type_id">Type de club</label>
                    <select class="form-control" name="club_type_id">
                        <option>Type de club...</option>
                        @foreach ($clubTypes as $clubType)
                            <option value="{{ $clubType->id }}">{{ $clubType->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('club_type_id', '<span class="help-block">:message</span>') !!}
                </div>
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
        </div>
    </div>
</div>
@endsection
