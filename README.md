# JellyFish
Most easy and dynamic Laravel CMS with build-in Language, User & media management. With `modules` you can build your own backend page witf pre-configured fields like eg. `text`, `textarea`, `select` etc. All fields will be stored inside a JSON column of the `jelly_types` table. Each page will be stored inside `jelly_content` table. On the front-end you can query them by using the `Jelly` static class like; `Jelly::Module('categories')->get()`.   

**Overview:**   
[Requirements](#requirements)  
[Installation](#installation)    
[Dynamic Content](#dynamic-content)  
-> [Add Module](#set-up-your-first-module)    
-> [Available fields](#available-fields) 


# Requirements

- Laravel 5.7.* (or higher)
- PHP 7.1 (or higher)
- Pre-configured DB (Supporting JSON columns)

## Packages
```
"graham-campbell/markdown": "^10.0",
"intervention/image": "^2.4"
```

## Installation
1. First install `composer require pinkwhalenl/jellyfish`.
2. Be sure your `.env` file is configured (DB).
3. Publish the config, css,js & font files `php artisan vendor:publish`.
4. Run the new migrations `php artisan migrate`.
5. Go to `https://{YOURDOMAIN}}.com/backend`.
6. Sign-in with the default credentials; `info@pinkwhale.io` & `secret`.

# Database understanding.
Inside the `jelly_types` table, will stored all `module` information like the fields.
```
id (unique) | sort(int) | type (module name) | title | data (all fields) | publish_date
```

Inside the `jelly_content` table, all document/pages are stored. Referenced with `type` to an `module`.  
**Table: `jelly_content`**
```
id (unique) | sort(int) | type (module name) | data (json as longText) | published_at | created_at | updated_at
```

# Dynamic content
Modules are like MySQL database tables, you'll define columns inside `modules` to structure you data and grouping them. On the Admin side of this platform you can add `fields` into you JSON file, and by telling each field what to do you'll get a customer friendly form. When you finished you're `module` you can start adding some documents from the navigation bar.

### Set-up an Module
1. Click on the right top side on your username. 
2. Click on `admin - Modules`. 
3. Click on `Create new Module`.
4. Add an `title` and also check some options who are needed in your case.
5. Start clean and add the following code.
```
{
    "fields":
        [
          
        ]
}
```
6. Fill the fields parts with the fields below.

**[Note] Default checkboxes while adding modules**   
you can check two checkboxes. `sort` & `published_at` those two are separated from the JSON data and have their own column inside the `jelly_content` table. You can also query them by the standard eloquent way.
```php
// Example with published_date.
Jelly::Module('example')->orderBy('published_at','desc')->get();
```

### Available fields

In each field you can still manage your validation rules brought from Laravel with the key `validation`. Also their are some functions to specify how the data will be stored inside your DB. Also has each `field` his own Options. So please check the documentation below.

#### Text field.
When you'll using a text field for title purposes, you can als add `"slug":true`. The system will automatically add the field `{name}_slug`. Note; you cannot change this afterwards when a document is already saved!
```JSON
{
    "title":"Title of document",
    "placeholder":"eg. This is a title",
    "type":"text",
    "name":"title",
    "slug":true,
    "validation":"required"
}
```
#### Markdown text.
```JSON
{
    "title":"Content",
    "placeholder":"...",
    "type":"markdown",
    "name":"content",
    "required":true,
    "validation":"required"
}
```
#### Media
```JSON
{
     "title":"Image",
     "placeholder":"...",
     "type":"media",
     "name":"picture",
     "required":true,
     "validation":"required"
}
```
#### Attachment
```JSON
{
     "title":"attachment",
     "placeholder":"...",
     "type":"media",
     "name":"pdf",
     "required":false,
     "function": ["attachment"]
}
```
#### Button
```JSON
{
    "title":"Button",
    "placeholder":"...",
    "type":"text",
    "name":"button"
}
```
#### Video
```JSON
{
    "title":"Video",
    "placeholder":"Youtube URL, for instance:  https://www.youtube.com/embed/ljMy9C5dEfE",
    "type":"text",
    "name":"video"
  }
```
#### Dates
You can also use as name `published_at` then it will be stored directly inside the `published_at` column instead of inside the data json column.
```JSON
{
     "title":"Publicatiedatum",
     "placeholder":"eg. 2022-12-31",
     "type":"date",
     "name":"date",
     "required":true,
     "function": {"format":"yyyy-mm-dd"},
     "validation":"required"
}       
```

# Front-end Integration
When you'll store a document eg. based on the selected `module`. All content will be stored inside the `data` column. This column is filled with the module's JSON values. 

#### Query stuff from your modules.
It's just Laravel, we did only the first few steps. So use the static function `Jelly::Module('MODULENAME')->{Query}`. On the background we take the `Content` model and query by type `->where('type','MODALNAME')`. 
```php
// example 1.
@foreach(Jelly::Module('articles')->get() as $article)
	<li>{{var_dump($article->data)}}</li>
@endforeach

// example 2.
$content = Jelly::Module('articles')->where('data->slug',$slug)->firstOrFail();

// example 3.
$content = Jelly:Module('articles')->where('data->code','7465')->first();
echo $content->created_at;
echo $content->data->title;
```
#### Images
Jellyfish supports a wide range of supporting images and image-caching.
```html
<!-- Where 'picture' is field's name.) -->
<img src="{{route('img',[$item->picture,'size=100x100'])}}"/>
```

### Using Markdown field
When using the markdown field add the `Markdown::convertToHtml()` function to convert markdown into HTML format.
```html
{!! Markdown::convertToHtml($data->data()->content) !!}
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

# Translations   
By default jellyfish will recognize laravel's running language. You can also force it to another language.

```php
{{Trans::get('home.title')}} // Most basic.
{{Trans::get('home.title','nl')}} // With language.
{{Trans::get('home.title','nl','lorem:10')}} // With language + Lorem Ipsum.
{{Trans::get('home.title',null,'lorem:10')}} // No language.
```


# On development environments

When you want to change this package from the `vendor` folder. `composer require pinkwhalenl/jellyfish dev-master --prefer-source`

#### Webpack

For compiling assets. Move the Sass, JS & fonts folder into your `resources/assets` folder structure.

```javascript
mix.sass('resources/assets/sass/jelly_auth.scss', 'public/css');
mix.sass('resources/assets/sass/jelly_default.scss', 'public/css');
mix.js('resources/assets/js/jelly_auth.js', 'public/js');
mix.js('resources/assets/js/jelly_default.js', 'public/js');

mix.copyDirectory('public/css', 'vendor/pinkwhalenl/jellyfish/src/assets/builds/css');
mix.copyDirectory('public/js', 'vendor/pinkwhalenl/jellyfish/src/assets/builds/js');
mix.copyDirectory('public/fonts', 'vendor/pinkwhalenl/jellyfish/src/assets/fonts');
```


