@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Événements</h1>
    <h2>{{ $event->name }}</h2>
    <h3>{{ $event->club->name }}</h3>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ url()->current() }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('id') ? 'has-error' : '' }}">
                    <label for="id">Membre non enregistré</label>
                    <select class="form-control" name="id">
                        <option>Membre non enregistré...</option>
                        @foreach ($anonymousUsers as $anonymousUser)
                            <option value="{{ $anonymousUser->id }}" {{ old('id') == $anonymousUser->id ? 'selected' : '' }}>{{ $anonymousUser->firstname }} {{ $anonymousUser->lastname }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('id', '<span class="help-block">:message</span>') !!}
                </div>
                <button type="submit" class="btn btn-default">Ajouter</button>
            </form>
        </div>
    </div>
</div>
@endsection
