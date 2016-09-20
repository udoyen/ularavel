@extends('layout.main')


@section('content')

    {!! Form::open(['route' => 'account-create-post', 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
        {!! Form::email('email') !!}
    </div>
    <div class="form-group">
        {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
        {!! Form::text('username') !!}
    </div>
    <div class="form-group">
        {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
        {!! Form::password('password', ['class' => 'awesome']) !!}

    </div>
    <div class="form-group">
        {!! Form::label('password_again', 'Password Again:', ['class' => 'control-label']) !!}
        {!! Form::password('password_again', ['class' => 'awesome']) !!}

    </div>
    {!! Form::submit('Create Account') !!}

    {!! Form::close() !!}

@endsection
