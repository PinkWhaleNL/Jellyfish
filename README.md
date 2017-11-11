
## Intervention
composer require intervention/image

composer require graham-campbell/markdown


@foreach(Jelly::Module('articles')->get() as $article)
	<li>{{var_dump($article->data(true))}}</li>
@endforeach