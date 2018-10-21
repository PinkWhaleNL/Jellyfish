# JellyFish
Most easy and dynamic Laravel CMS with build-in Language, User & media management. With `modules` you can build your own backend page witf pre-configured fields like eg. `text`, `textarea`, `select` etc. All fields will be stored inside a JSON column of the `jelly_types` table. Each page will be stored inside `jelly_content` table. On the front-end you can query them by using the `Jelly` static class like; `Jelly::Module('categories')->get()`.   

**Overview:**   
- [Requirements](#requirements)
- [Installation](#installation)
- [Upgrade guide](#upgrade-guide)
- [Dynamic Content](#dynamic-content)
- [Add Module](#add-module)
- [Available fields](#available-fields)
	- [Text field](#text)
	- [Markdown field](#markdown)
	- [Picture field](#picture)
	- [Attachment field](#attachment)
- [Front-end Usage](#front-end-usage)
	- [Get document from selected module](#get-document-from-selected-module)
	- [Print Images](#print-images)
	- [Using Markdown field](#using-markdown-field)
	- [Using Markdown field](#using-markdown-field)
- [Store your Forms](#store-forms)
- [Authentication](#authentication)
- [Translations](#translations)
- [Development](#on-development-environments)


# Requirements
- Laravel 5.7.* (or higher)
- PHP 7.1 (or higher)
- Pre-configured DB (Supporting JSON columns)

# Upgrade guide
*No `data()` needed anymore* to get your field data from a document. Now you can do `$result->data->title`. Also you can query inside the `data` column of the `jelly_content` table. Please update your code, in the next versions `data()` function will be removed.

# Installation
1. Run `composer require pinkwhalenl/jellyfish`.
2. Be sure your `.env` file is configured (DB).
3. Publish the config, css,js & font files `php artisan vendor:publish`.
4. Run the new migrations `php artisan migrate`.
5. Go to `https://{YOURDOMAIN}}.com/backend`.
6. Sign-in with the default credentials; `info@pinkwhale.io` & `secret`.

# Dynamic content
Modules are like MySQL database tables, you'll define columns inside `modules` to structure you data and grouping them. On the Admin side of this platform you can add `fields` into you JSON file, and by telling each field what to do you'll get a customer friendly form. When you finished you're `module` you can start adding some documents from the navigation bar.

### Add Module
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

#### Text
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
#### Markdown
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
#### Picture
This field let you select an image from the Media library.
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
This field let you select an file from the Media library.
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

# Front-end usage
When you'll store a document eg. based on the selected `module`. All content will be stored inside the `data` column. This column is filled with the module's JSON values. 

#### Get document from selected module
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
#### Print images
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

# Store Forms
CMS stores and let you manage your form data. See example below; 
```php
// ExampleController.php
use JellyForms;

public function store(){
    // Validate
    request()->validate([
        'name' => 'required',
    ]);
    
    // Store
    JellyFroms::put('contact_form',request()->all());
    
    // Store -> Alternatice
    JellyForms::put('contact_form',[
        'name' => request()->name,
	'email' => request()->email
    ]);
    
    return redirect()->route('ROUTENAME')->with('alert','success');
}
```


# Authentication

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
