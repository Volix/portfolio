@extends('layouts.master.auth.app')
@section ('content')
{!! Form::open(['url'=>route('login')]) !!}
    {!! Form::text('email',null,  ['required'=>'required', "type"=>"email", 'placeholder' => "Email"]) !!}
    {!! Form::password('password', null, ['required'=>'required', "type"=>"password"])!!}
    {!! Form::label('remember_me', 'Zapamiętaj mnie')!!}
    {!! Form::checkbox('remember_me', true)!!}
    {!! Form::submit('zaloguj')!!}
{!! Form::close() !!}
@endsection