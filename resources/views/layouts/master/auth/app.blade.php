<!DOCTYPE html>
<html lang="pl">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="{{url()}}/styles/auth/app.css" type="text/css">
    </head>
    <body>
        @if (count($errors)>0)
            <div class="errors_box communication_box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
            </div>
        @endif
        
        @if (Session::has('communication_error'))
            
            <div class="errors_box communication_box">
                <ul>
                @foreach (Session::get('communication_error') as $communication)
                    <li>{{$communication}}</li>
                @endforeach
                </ul>
            </div>
        
        @elseif (Session::has('communication_success'))
        
            <div class="success_box communication_box">
                <ul>
                @foreach (Session::get('communication_success') as $communication)
                    <li>{{$communication}}</li>
                @endforeach
                </ul>
            </div>
        
        @elseif (Session::has('communication_info'))

            <div class="info_box communication_box">
                <ul>
                @foreach (Session::get('communication_info') as $communication)
                    <li>{{$communication}}</li>
                @endforeach
                </ul>
            </div>
        
        @endif
        
        @yield('content')
        
        <footer>
            
        </footer>
        @extends('resource.scripts')
        </body>
        
</html>