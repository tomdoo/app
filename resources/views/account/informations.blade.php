@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon profil</h1>
    <div class="row">
        <div class="col-xs-12">
            <p>Modification de mon profil</p>
            <div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
        </div>
    </div>
</div>
@endsection
