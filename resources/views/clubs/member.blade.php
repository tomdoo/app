@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <h2>{{ $club->name }}</h2>
    <h3>Membres</h3>
    <h4>{{ $member->name }}</h4>
    <div class="row">
        <div class="col-xs-12">
            @if ($events->count())
                <graph-component data-events='@json($events)' data-months='@json($months)' />
            @else
                <p>Aucune participation</p>
            @endif
        </div>
    </div>
</div>
@endsection
