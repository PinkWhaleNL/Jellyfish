
# JellyFish - Easy CMS system.

1. First install `composer require pinkwhalenl/jellyfish`.
2. Publish all css,js and font files. `php artisan vendor:publish --provider="Pinkwhale/Jellyfish/PackageServiceProvider"`


@foreach(Jelly::Module('articles')->get() as $article)
	<li>{{var_dump($article->data(true))}}</li>
@endforeach