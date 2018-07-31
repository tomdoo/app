@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Clubs</h1>
    <h2>{{ $club->name }}</h2>
    <h3>Membres actifs</h3>
    <div class="row">
        <div class="col-xs-12">
            @if ($club->members)
                <h4>Membres enregistrés</h4>
                <ul class="list-unstyled">
                    @foreach ($club->members as $clubMember)
                        <li>
                            <a href="{{ route('clubs.member', [$club->id, $clubMember->id]) }}">{{ $clubMember->name }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
            @if ($club->anonymousMembers)
                <h4>Membres non enregistrés</h4>
                <ul class="list-unstyled">
                    @foreach ($club->anonymousMembers as $anonymousClubMember)
                        <li>
                            <a href="{{ route('clubs.anonymousMember', [$club->id, $anonymousClubMember->id]) }}">{{ $anonymousClubMember->firstname }} {{ $anonymousClubMember->lastname }}</a>
                        </li>
                    @endforeach
                </ul>
                <a class="btn btn-default btn-block" href="{{ route('clubs.addAnonymousMember', $club->id) }}">Ajouter un membre non-enregistré</a>
            @endif
        </div>
    </div>
</div>
@endsection
