@extends("layouts.master")
@section('title', $project['name'])
@section('content')
<article>
    <header>
        <h1>{{$project['name']}}</h1>
    </header>
    <section>
	<ul class="slideshow">
	
	</ul>
        {!! $project['description'] !!}
    </section>
    <footer>
        
	</footer>
</article>
@endsection