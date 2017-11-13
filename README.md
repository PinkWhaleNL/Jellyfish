
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

## Front-end

### Translations   
By default jellyfish will recognize laravel's language. You can also force it to another language.

```php
{{Trans::get('home.title')}} // Most basic.
{{Trans::get('home.title','nl')}} // With language.
{{Trans::get('home.title','nl','lorem:10')}} // With language + Lorem Ipsum.
{{Trans::get('home.title',null,'lorem:10')}} // No language.
```

### Query stuff from your modules.

```
@foreach(Jelly::Module('articles')->get() as $article)
	<li>{{var_dump($article->data(true))}}</li>
@endforeach
```

### Authentications.

You can check if a user has signed in by typing `JellyAuth::Check()` this functions returns `true/false`. You can also get all user's information by using the `User()` function like; `JellyAuth::User()`. When you want to know if an user has `admin-access` then type; `JellyAuth::IsAdmin()`, this also returns `true/false`.

**Example**
```php
// Show button is signed in.
@if(JellyAuth::Check())
	<ul>
		<li><a href="#">Click here..</a></li>
	</ul>
@endif

// Check user is an Admin.
@if(JellyAuth::IsAdmin())
	<li><a href="#">[Admin] - Debtors..</a></li>
@endif

// Get Userdata.
JellyAuth::User()->id // Get unique ID
JellyAuth::User()->name // Get name
JellyAuth::User()->email // Get email

```

