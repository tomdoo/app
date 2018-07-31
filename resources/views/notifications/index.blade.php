@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notifications</h1>
    <div class="row">
        <div class="col-xs-12">
            @if ($notifications->count() > 0)
                <ul class="list-group">
                    @foreach ($notifications->sortBy('created_at') as $notification)
                        <li class="list-group-item {{ is_null($notification->read_at) ? 'list-group-item-success' : '' }}">
                            {{ $notification->read_at }}
                            {{ $notification->data['title'] }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Aucune notification</p>
            @endif
        </div>
    </div>
</div>
@endsection
