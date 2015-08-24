@if (sizeof($projects)>0)
	<ul>
		@foreach ($projects as $project)
			<li>
				<article>
					<header>
						<h1>
							{!!link_to_action('projectsController@findBySlug', $project['name'], $project['slug'])!!}
						</h1>
					</header>
					<section>
						{!! $project['short_description'] !!}
					</section>
					<footer>
						<ul>
							<li>Wykonano: <span>{{ $project['made_at'] }} </span></li>
							<li>Dodano: <span>{{ $project['created_at'] }}</span></li>
							<li>Ostatnia modyfikacja: <span>{{ $project['updated_at'] }}</span></li>
							<li>{!!link_to_action('projectsController@findBySlug', "Pokaż", $project['slug'])!!}</li>
							<li>{!!link_to_action('projectsController@edit', "Edytuj", $project['id'])!!}</li>
							<li>{!!link_to_action('projectsController@destroy', "Usuń", $project['id'])!!}</li>
						</ul>
					</footer>
				</article>
			</li>
		@endforeach
	</ul>
@endif