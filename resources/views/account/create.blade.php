@extends('layout.main')


@section('content')    

    {!! Form::open(['route' => 'account-create-post', 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
        {!! Form::email('email') !!}
        @if($errors->has('email'))
            {{ $errors->first('email') }}
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
        {!! Form::text('username') !!}
        @if($errors->has('username'))
            {{ $errors->first('username') }}
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}
        {!! Form::password('password', ['class' => 'awesome']) !!}
        @if($errors->has('password'))
            {{ $errors->first('password') }}
        @endif

    </div>
    <div class="form-group">
        {!! Form::label('password_again', 'Password Again:', ['class' => 'control-label']) !!}
        {!! Form::password('password_again', ['class' => 'awesome']) !!}
        @if($errors->has('password_again'))
            {{ $errors->first('password_again') }}
        @endif

    </div>
    {!! Form::submit('Create Account') !!}

    {!! Form::close() !!}

@endsection
