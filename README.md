
# JellyFish - Easy CMS system.

1. First install `composer require pinkwhalenl/jellyfish`.
2. Be sure your `.env` file is configured (DB).
3. Run the net migrations `php artisan migrate`.
4. Seed the DB with the first user. `php artisan db:seed`.
5. Publish all css,js and font files. `php artisan vendor:publish`  Choose the pinkwhale package to be published.
6. Sign-in as `info@pinkwhale.io` with the password `secret`.


### Modules.
You can pick a various types. Check the [wiki-page](https://github.com/PinkWhaleNL/Jellyfish/wiki/Module-types) for more information.

**Example**
```
{
    "fields":
        [
          ...
        ]
}
```

### Front-end

**List all rows from a module**
```
@foreach(Jelly::Module('articles')->get() as $article)
	<li>{{var_dump($article->data(true))}}</li>
@endforeach
```

