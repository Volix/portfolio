@extends('layouts.master.auth.app')
@section('content')
    {!! Form::open(['url'=>route('register')]) !!}
        
        {!! Form::label('name' ,"Nazwa") !!}
        {!! Form::text('name', null, ['required'=>'required']) !!}
         
        {!! Form::label('email' ,"Email") !!}
        {!! Form::email('email', null, ['required'=>'required']) !!}
        
    {!! Form::label('password' ,"Hasło") !!}
        {!! Form::password('password', null, ['required'=>'required']) !!}
        
    {!! Form::label('password_confirmation' ,"Powtórz hasło") !!}
        {!! Form::password('password_confirmation', null, ['required'=>'required']) !!}
        
        {!! Form::submit('Zarejestruj') !!}
            
    {!! Form::close() !!}
@endsection