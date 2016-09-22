@extends('layout.main')

@section('content')

    {!! Form::open(['route' => 'account-forgot-password-post', 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
        {!! Form::email('email') !!}
        @if($errors->has('email'))
            {{ $errors->first('email') }}
        @endif
    </div>
    {!! Form::submit('Recover') !!}

    {!! Form::close() !!}

@endsection