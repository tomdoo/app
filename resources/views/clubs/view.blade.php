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
                @if ($club->description)
                    <dt>Description</dt>
                    <dd>{{ $club->description }}</dd>
                @endif
                @if ($club->owner_alias)
                    <dt>Nom du responsable</dt>
                    <dd>{{ $club->owner_alias }}</dd>
                @endif
                @if ($club->address)
                    <dt>Adresse</dt>
                    <dd>{{ $club->address }}</dd>
                @endif
                @if ($club->postcode)
                    <dt>Code postal</dt>
                    <dd>{{ $club->postcode }}</dd>
                @endif
                @if ($club->city)
                    <dt>Ville</dt>
                    <dd>{{ $club->city }}</dd>
                @endif
                @if ($club->country)
                    <dt>Pays</dt>
                    <dd>{{ $club->country->name }}</dd>
                @endif
                @if ($club->phone)
                    <dt>Numéro de téléphone</dt>
                    <dd>{{ $club->phone }}</dd>
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
