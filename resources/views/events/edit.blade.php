@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Événements</h1>
    <h2>Nouvel événément</h2>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" action="{{ url()->current() }}">
                {{ csrf_field() }}
                @if ($clubs->count() == 1)
                    <input type="hidden" value="{{ $clubs->first()->id }}" name="club_id" />
                @else
                    <div class="form-group {{ $errors->has('club_id') ? 'has-error' : '' }}">
                        <label for="club_id">Club</label>
                        <select class="form-control" name="club_id" {{ !empty($event->club_id) ? 'disabled' : '' }}>
                            <option>Club...</option>
                            @foreach ($clubs as $club)
                                <option value="{{ $club->id }}" {{ old('club_id', $event->club_id) == $club->id ? 'selected' : '' }}>{{ $club->name }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('club_id', '<span class="help-block">:message</span>') !!}
                    </div>
                @endif
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Nom de l'événement</label>
                    <input type="text" class="form-control" placeholder="Nom de l'événement" value="{{ old('name', $event->name) }}" name="name" />
                    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('start_date') ? 'has-error' : '' }}">
                    <label for="start_date">Date et heure de début</label>
                    <input type="text" class="form-control" placeholder="Date et heure de début" value="{{ old('start_date', !empty($event->start_date) ? $event->start_date->format('Y-m-d H:i') : null) }}" name="start_date" />
                    {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('end_date') ? 'has-error' : '' }}">
                    <label for="end_date">Date et heure de fin</label>
                    <input type="text" class="form-control" placeholder="Date et heure de fin" value="{{ old('end_date', !empty($event->end_date) ? $event->end_date->format('Y-m-d H:i') : null) }}" name="end_date" />
                    {!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
                </div>
                @if (!$event->exists)
                    <div class="form-group {{ $errors->has('recurrence') ? 'has-error' : '' }}">
                        <label for="recurrence">Récurrence</label>
                        <select class="form-control" name="recurrence">
                            <option>Récurrence...</option>
                            @foreach ($recurrences as $recurrenceKey => $recurrenceValue)
                                <option value="{{ $recurrenceKey }}" {{ old('recurrence', $event->recurrence) == $recurrenceKey ? 'selected' : '' }}>{{ $recurrenceValue }}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('recurrence', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group {{ $errors->has('recurrence_end_date') ? 'has-error' : '' }}">
                        <label for="recurrence_end_date">Date de fin de récurrence</label>
                        <input type="text" class="form-control" placeholder="Date de fin de récurrence" value="{{ old('recurrence_end_date', !empty($event->recurrence_end_date) ? $event->recurrence_end_date->format('Y-m-d') : null) }}" name="recurrence_end_date" />
                        {!! $errors->first('recurrence_end_date', '<span class="help-block">:message</span>') !!}
                    </div>
                @endif
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="address">Adresse</label>
                    <textarea class="form-control" placeholder="Adresse" name="address">{{ old('address', $event->address) }}</textarea>
                    {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('postcode') ? 'has-error' : '' }}">
                    <label for="postcode">Code postal</label>
                    <input type="text" class="form-control" placeholder="Code postal" value="{{ old('postcode', $event->postcode) }}" name="postcode" />
                    {!! $errors->first('postcode', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                    <label for="city">Ville</label>
                    <input type="text" class="form-control" placeholder="Ville" value="{{ old('city', $event->city) }}" name="city" />
                    {!! $errors->first('city', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
                    <label for="country_id">Pays</label>
                    <select class="form-control" name="country_id">
                        <option>Pays...</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id', $event->country_id) == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    {!! $errors->first('country_id', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('max_participants') ? 'has-error' : '' }}">
                    <label for="max_participants">Nombre de participants maximal</label>
                    <input type="text" class="form-control" placeholder="Nombre de participants maximal" value="{{ old('max_participants', $event->max_participants) }}" name="max_participants" />
                    {!! $errors->first('max_participants', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description">Description</label>
                    <textarea class="form-control" placeholder="Description" name="description">{{ old('description', $event->description) }}</textarea>
                    {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                    <label for="price">Prix</label>
                    <input type="text" class="form-control" placeholder="Prix" value="{{ old('price', $event->price) }}" name="price" />
                    {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
                </div>
                @if (!empty($event->recurrence))
                    <div class="form-group {{ $errors->has('change_all_occurrences') ? 'has-error' : '' }}">
                        <label>
                            <input type="checkbox" value="1" name="change_all_occurrences" {{ old('change_all_occurrences') ? 'checked' : '' }} />
                            Appliquer à toutes les occurences futures
                        </label>
                    </div>
                @endif
                <button type="submit" class="btn btn-default">Sauvegarder</button>
            </form>
        </div>
    </div>
</div>
@endsection
