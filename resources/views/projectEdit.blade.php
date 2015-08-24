@if (isset($errors))
	@foreach ($errors as $error)
		{{$error}}
	@endforeach
@endif
{!!Form::open(array('url'=>route('projectUpdate', ['id' => $project['id']])))!!}
	{!!Form::label ('name', 'Nazwa projektu: ')!!}
	{!!Form::text ('name', $project['name'])!!}
	{!!Form::label ('short_description', 'Krótki opis: ')!!}
	{!!Form::textarea ('short_description', $project['short_description'], array('maxlength' =>  '250'))!!}
	{!!Form::label ('description', 'Opis: ')!!}
	{!!Form::textarea ('description', $project['description'])!!}
	{!!Form::label ('project_url', 'Strona projektu: ')!!}
	{!!Form::url ('project_url', $project['url'])!!}
	{!!Form::label ('made_at', 'Data wykonania: ')!!}
	{!!Form::date ('made_at', $project['made_at'])!!}
	{!!Form::submit ('Zaaktualizuj')!!}
{!!Form::close()!!}