@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <h2>{{ $club->name }}</h2>
    <div class="row">
        <div class="col-xs-12">
            <dl class="dl-horizontal">
                <dt>Type de club</dt>
                <dd>{{ $club->clubType->name }}</dd>
                @if ($club->owners->contains($user->id) || $club->administrators->contains($user->id))
                    <dt>Code d'accès</dt>
                    <dd>{{ $club->access_code }}</dd>
                @endif
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @if ($club->owners->contains($user->id) || $club->administrators->contains($user->id))
                <a class="btn btn-default btn-block" href="{{ route('clubs.edit', $club->id) }}">Modifier</a>
            @endif
            @if ($club->owners->contains($user->id))
                <a class="btn btn-danger btn-block" href="{{ route('clubs.delete', $club->id) }}">Supprimer</a>
            @endif
        </div>
    </div>
</div>
@endsection
