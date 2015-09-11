{!!Form::open(array('url'=>route('projectCreate'), 'files'=>true))!!}
    {!!Form::label ('name', 'Nazwa projektu: ')!!}
    {!!Form::text ('name')!!}
    {!!Form::label ('short_description', 'Krótki opis: ')!!}
    {!!Form::textarea ('short_description', null, array('maxlength' =>  '250'))!!}
    {!!Form::label ('description', 'Opis: ')!!}
    {!!Form::textarea ('description')!!}
    {!!Form::label ('project_url', 'Strona projektu: ')!!}
    {!!Form::url ('project_url')!!}
    {!!Form::label ('made_at', 'Data wykonania: ')!!}
    {!!Form::date ('made_at')!!}
	{!!Form::label ('distinctive_image', 'Grafika wyróżniająca')!!}
	{!!Form::label ('images', 'Pozostałe grafiki')!!}
		{!!Form::file('images[]', ['multiple'=>'multiple', 'class'=>'dropzone'])!!}
    {!!Form::submit ('Dodaj')!!}
{!!Form::close()!!}