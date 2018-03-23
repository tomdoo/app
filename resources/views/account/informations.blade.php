@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mon profil</h1>
    <div class="row">
        <div class="col-xs-12">
            <p>Modification de mon profil</p>
            
            {!! Form::open() !!}
                <div class="form-group">
                    {!! Form::label('email', 'Adresse email') !!}
                    {!! Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Adresse email']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('firstname', 'Prénom') !!}
                    {!! Form::text('firstname', '', ['class' => 'form-control', 'placeholder' => 'Prénom']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('lastname', 'Nom') !!}
                    {!! Form::text('lastname', '', ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('birth_date', 'Date de naissance') !!}
                    {!! Form::date('birth_date', '', ['class' => 'form-control', 'placeholder' => 'Date de naissance']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('sexe', 'Sexe') !!}
                    {!! Form::select('sexe', [1 => 'Homme', 2 => 'Femme'], null, ['class' => 'form-control', 'placeholder' => 'Sexe...']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('phone', 'Numéro de téléphone') !!}
                    {!! Form::text('phone', '', ['class' => 'form-control', 'placeholder' => 'Numéro de téléphone']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('newsletter', 'Newsletter') !!}
                    {!! Form::checkbox('newsletter', '', true) !!}
                </div>
            {!! Form::close() !!}

            <div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </div>
        </div>
    </div>
</div>
@endsection
