@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <h2>{{ $club->name }}</h2>
    <div class="row">
        <div class="col-xs-12">
            <dl class="dl-horizontal">
                <dt>Photos</dt>
                <dd>
                    @if ($club->photos->count())
                        <div class="row">
                            @foreach ($club->photos as $photo)
                                <div class="col-xs-4">
                                    <div class="thumbnail">
                                        <img src="{{ route('clubs.getPhoto', [$club->id, $photo->id]) }}" height="100" />
                                        <div class="caption">
                                            <p>
                                                <a href="{{ route('clubs.setPrimaryPhoto', [$club->id, $photo->id]) }}" class="btn btn-{{ $photo->primary ? 'primary' : 'default' }}">Photo principale</a>
                                                <a href="{{ route('clubs.deletePhoto', [$club->id, $photo->id]) }}" class="btn btn-danger">Supprimer</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <form method="POST" enctype="multipart/form-data" action="{{ route('clubs.addPhoto', $club->id) }}">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('file') ? 'has-error' : '' }}">
                            <label for="file">Ajouter une photo</label>
                            <input type="file" class="form-control" placeholder="Ajouter une photo" name="file" />
                            {!! $errors->first('file', '<span class="help-block">:message</span>') !!}
                        </div>
                        <button type="submit" class="btn btn-default btn-block">Ajouter</button>
                    </form>
                </dd>
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
