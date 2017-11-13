
# JellyFish - Easy CMS system.

1. First install `composer require pinkwhalenl/jellyfish`.
2. Be sure your `.env` file is configured (DB).
3. Run the net migrations `php artisan migrate`.
4. Publish all css,js and font files. `php artisan vendor:publish`  Choose the pinkwhale package to be published.
5. Go to `https://{YOURDOMAIN}}.com/backend`. Also will be `backend` the default url. You can change it inside je Jellyfish config file.
5. Sign-in as `info@pinkwhale.io` with the password `secret`.


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

**Translations**
On default jellyfish will recognize default laravel language. You can also force it to another language.
```php
{{Trans::get('home.title')}}
```
With language:
```php
{{Trans::get('home.title','nl')}}
```

**Query stuff from your modules.**
```
@foreach(Jelly::Module('articles')->get() as $article)
	<li>{{var_dump($article->data(true))}}</li>
@endforeach
```

