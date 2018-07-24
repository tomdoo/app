@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Événements</h1>
    <h2>{{ $event->name }}</h2>
    
    @if (!empty($event->club_photo_id))
        <div class="row">
            <div class="col-xs-12">
                <img src="{{ route('clubs.getPhoto', [$event->club->id, $event->club_photo_id]) }}" />
            </div>
        </div>
    @elseif ($event->club->primaryPhoto->count())
        <div class="row">
            <div class="col-xs-12">
                <img src="{{ route('clubs.getPhoto', [$event->club->primaryPhoto->first()->id]) }}" />
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-12">
            <dl class="dl-horizontal">
                <dt>Club</dt>
                <dd>{{ $event->club->name }}</dd>
                <dt>Date de début</dt>
                <dd>{{ $event->start_date }}</dd>
                <dt>Date de fin</dt>
                <dd>{{ $event->end_date }}</dd>
                <dt>Description</dt>
                <dd>{{ $event->description }}</dd>
                <dt>Nombre de participants</dt>
                <dd>{{ $event->participants()->count() + $event->anonymousParticipants()->count() }}/{{ $event->max_participants }}</dd>
                <dt>Participants</dt>
                <dd>
                    @if ($event->participants->count() || $event->anonymousParticipants->count())
                        <ul>
                            @if ($event->participants->count())
                                @foreach ($event->participants as $participant)
                                    <li>{{ $participant->name }}</li>
                                @endforeach
                            @endif
                            @if ($event->anonymousParticipants->count())
                                @foreach ($event->anonymousParticipants as $participant)
                                    <li>
                                        {{ $participant->firstname }} {{ $participant->lastname }} (non-enregistré)
                                        <a href="{{ route('events.unsubscribeAnonymous', [$event->id, $participant->id]) }}" class="btn btn-default">Désinscire</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    @else
                        Aucun
                    @endif
                </dd>
                @if ($event->club->administrators->contains($user->id))
                @endif
                <dt>Tarif</dt>
                <dd>{{ $event->price }}</dd>
                <dt>Lieu</dt>
                <dd>
                    {{ $event->address }}<br />
                    {{ $event->postcode }} {{ $event->city }}<br />
                </dd>
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            @if ($event->participants->contains($user->id))
                <a class="btn btn-default btn-block" href="{{ route('events.participate', [$event->id, 0]) }}">Ne plus participer</a>
            @elseif ($event->participants->count() + $event->anonymousParticipants->count() >= $event->max_participants)
                <span class="btn btn-default btn-block disabled">Complet</span>
            @else
                <a class="btn btn-default btn-block" href="{{ route('events.participate', [$event->id, 1]) }}">Participer</a>
            @endif
            
            @if ($event->participants->count() + $event->anonymousParticipants->count() < $event->max_participants)
                <a class="btn btn-default btn-block" href="{{ route('events.subscribeAnonymous', [$event->id]) }}">Inscrire un membre non-enregistré</a>
            @endif

            @if ($event->club->administrators->contains($user->id))
                <a class="btn btn-default btn-block" href="{{ route('events.edit', $event->id) }}">Modifier</a>
                <a class="btn btn-danger btn-block" href="{{ route('events.delete', $event->id) }}">Supprimer</a>
            @endif
        </div>
    </div>
</div>
@endsection
