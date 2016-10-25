@extends('layout.main')


@section('content')

    {!! Form::open(['route' => 'account-change-password-post', 'method' => 'post']) !!}
    <div class="form-group">
        {!! Form::label('old_password', 'Old Password:', ['class' => 'control-label']) !!}
        {!! Form::password('old_password') !!}
        @if($errors->has('old_password'))
            {{ $errors->first('old_password') }}
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('new_password', 'New Password:', ['class' => 'control-label']) !!}
        {!! Form::password('new_password', ['class' => 'awesome']) !!}
        @if($errors->has('new_password'))
            {{ $errors->first('new_password') }}
        @endif
    </div>
    <div class="form-group">
        {!! Form::label('new_password_again', 'New Password Again:', ['class' => 'control-label']) !!}
        {!! Form::password('new_password_again', ['class' => 'awesome']) !!}
        @if($errors->has('new_password_again'))
            {{ $errors->first('new_password_again') }}
        @endif
    </div>

    {!! Form::submit('Change Password') !!}

    {!! Form::close() !!}

@endsection