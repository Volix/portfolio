@extends("layouts.master")
@section("title", "Moje projekty")
{{var_dump($projects)}}
<a href="{{route('projectCreate')}}">Dodaj</a>
	{!!link_to_action('projectsController@manage', "test")!!}
