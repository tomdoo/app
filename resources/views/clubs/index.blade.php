@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <div class="row">
        <div class="col-xs-12">
            <h2>Clubs dont je suis membre</h2>
            <a href="{{ route('clubs.addMember') }}" class="btn btn-default btn-block">Ajouter un club</a>
            @foreach ($memberedClubs as $club)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $club->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Type de club</dt>
                            <dd>{{ $club->clubType->name }}</dd>
                        </dl>
                        <a class="btn btn-default btn-block" href="{{ route('clubs.view', $club->id) }}">Détails</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h2>Clubs que je gère</h2>
            <a href="{{ route('clubs.create') }}" class="btn btn-default btn-block">Ajouter un club</a>
            @foreach ($ownedClubs as $club)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $club->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Type de club</dt>
                            <dd>{{ $club->clubType->name }}</dd>
                        </dl>
                        <a class="btn btn-default btn-block" href="{{ route('clubs.view', $club->id) }}">Détails</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
