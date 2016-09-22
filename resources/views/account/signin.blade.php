@extends('layout.main')

@section('content')

    {!! Form::open(['route' => 'account-sign-in-post', 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
        {!! Form::email('email') !!}
        @if($errors->has('email'))
            {{ $errors->first('email') }}
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
        {!! Form::label('remember', 'Remember me', ['class' => 'control-label']) !!}
        {!! Form::checkbox('remember') !!}
    </div>

    {!! Form::submit('Sign In') !!}

    {!! Form::close() !!}
@endsection