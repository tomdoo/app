@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Événements</h1>
    <div class="row">
        <div class="col-xs-12">
            <h2>Événements des clubs dont je suis membre</h2>
            @foreach ($memberedClubsEvents as $event)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $event->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Date de début</dt>
                            <dd>{{ $event->start_date }}</dd>
                            <dt>Date de fin</dt>
                            <dd>{{ $event->end_date }}</dd>
                        </dl>
                        <a class="btn btn-default btn-block" href="{{ route('events.view', $event->id) }}">Détails</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
    	<div class="col-xs-12">
    		<h2>Événements que je gère</h2>
    		<a href="{{ route('events.create') }}" class="btn btn-default btn-block">Ajouter un événement</a>
            @foreach ($administratedClubsEvents as $event)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $event->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt>Date de début</dt>
                            <dd>{{ $event->start_date }}</dd>
                            <dt>Date de fin</dt>
                            <dd>{{ $event->end_date }}</dd>
                        </dl>
                        <a class="btn btn-default btn-block" href="{{ route('events.view', $event->id) }}">Détails</a>
                    </div>
                </div>
            @endforeach
    	</div>
    </div>
</div>
@endsection
