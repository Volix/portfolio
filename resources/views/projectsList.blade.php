@extends("layouts.master")
@section("title", "Moje projekty")
@section('content')
{{var_dump($projects)}}
<ul class="projectsList">
    @foreach ($projects as $project)
    <li>
    @if (!empty($project['distinctive_image']))
        <img src-"{{$project['distinctive_image']}}" class="distinctive_image">
    @endif
    <div class="short_description">
        {{$project['short_description']}}
            {!!link_to_action('projectsController@findBySlug', "Czytaj więcej", $project['slug']) !!}
            {!!link_to_action('projectsController@findBySlug', "Pokaż", $project['slug'])!!}
    </div>
    </li>
    @endforeach
</ul>
@endsection