@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <h2>M'abonner à un club</h2>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ url('clubs/member') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('access_code') ? 'has-error' : '' }}">
                    <label for="access_code">Code du club</label>
                    <input type="text" class="form-control" placeholder="Code du club" value="{{ old('access_code') }}" name="access_code" />
                    {!! $errors->first('access_code', '<span class="help-block">:message</span>') !!}
                </div>
                <button type="submit" class="btn btn-default btn-block">Ajouter</button>
            </form>
        </div>
    </div>
</div>
@endsection
