
# JellyFish - Easy CMS system.

1. First install `composer require pinkwhalenl/jellyfish`.
2. Publish all css,js and font files. `php artisan vendor:publish --provider="Pinkwhale/Jellyfish/PackageServiceProvider"`


### First Time login.
Default username: `info@pinkwhale.io` & password: `secret`.


### Modules.

**Example**
```
{
    "fields":
        [
            
            {
                "title":"Title of document",
                "placeholder":"eg. This is a title",
                "type":"text",
                "name":"title",
                "required":true,
                "function":["slug"],
                "validation":"required"
            },
            {
                "title":"Title of document2",
                "placeholder":"eg. This is a title",
                "type":"text",
                "name":"title2",
                "required":true,
                "function":["slug"],
                "validation":"required"
            },
            {
                "title":"Content",
                "placeholder":"eg. This is a title",
                "type":"markdown",
                "name":"content",
                "required":true,
                "function":["base64"],
                "validation":"required"
            },
            {
                "title":"Afbeelding",
                "placeholder":"Kies een afbeelding",
                "type":"media",
                "name":"picture",
                "required":true,
                "function":["picture"],
                "validation":"required"
            }   
            
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

