<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title') {{$settings['separator']}} {{$settings['site_title']}}</title>
		<meta name='description' content='{{$settings['site_description']}}'>
		<meta name='keywords' content='{{$settings['site_keywords']}}'>
    </head>
    <body>
		<section role="main">
			@yield('content')
		</section>
		<aside role="sidebar">
		
		</aside>
		<footer>
			&copy; {{$settings['site_name']}} {{$settings['site_start_year']}} - {{date('Y')}}
		</footer>
		<script src="{{url()}}/js/jquery.js"></script>
    </body>
</html>
