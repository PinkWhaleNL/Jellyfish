<?php

// Accessible by un-authenticated users.
Route::get('/media/image/{id}', 'Pinkwhale\Jellyfish\Controllers\MediaController@displayCustomImage')->name('img');
Route::get('/media/picture/{unique}', 'Pinkwhale\Jellyfish\Controllers\MediaController@displayPicture')->name('media-picture');
Route::get('/media/file/{unique}', 'Pinkwhale\Jellyfish\Controllers\MediaController@displayFile')->name('media');

// This group sets the namespace, prefix and the default laravel's web middleware.
Route::group(['middleware'=>'web', 'namespace'=>'Pinkwhale\Jellyfish\Controllers','prefix'=>config('jf.slug')], function () {

    // Redirect if no option has set.
    Route::redirect('/', config('jf.slug').'/dashboard');

    // Authentication
    Route::resource('login', 'AuthController');
    Route::get('logout', 'AuthController@logout')->name('jelly-logout');
    Route::group(['middleware'=>'Pinkwhale\Jellyfish\Middleware\Auth'], function () {

        // Main dashboard stuff.
        Route::get('dashboard', 'DashboardController@show')->name('jelly-dashboard');

        // Language
        Route::get('translations', 'TranslationsController@index')->name('jelly-translations');
        Route::get('translations/new', 'TranslationsController@create')->name('jelly-translation-create');
        Route::post('translations/new', 'TranslationsController@store');
        Route::get('translations/{id}', 'TranslationsController@show')->name('jelly-translation');
        Route::post('translation-item/{id}', 'TranslationsController@store_item')->name('jelly-translation-item');
        Route::post('translation-item-remove/{id}', 'TranslationsController@destroy_item')->name('jelly-translation-item-remove');
        Route::post('translations-remove/{id}', 'TranslationsController@destroy')->name('jelly-translation-remove');

        // Media
        Route::get('media', 'MediaController@index')->name('jelly-media');
        Route::get('media-files', 'MediaController@index_files')->name('jelly-media-files');
        Route::get('media-pictures', 'MediaController@index_pictures')->name('jelly-media-pictures');
        Route::get('media/{id}', 'MediaController@show')->name('jelly-media-show');
        Route::post('media/{id}', 'MediaController@store');
        Route::post('media-remove/{id}', 'MediaController@destroy')->name('jelly-media-remove');

        // Forms
        Route::get('forms', 'FormsController@index')->name('jelly-forms');
        Route::get('forms/{id}', 'FormsController@show')->name('jelly-form');

        // Modules.
        Route::get('modules/{name}', 'TypesController@index')->name('jelly-modules');
        Route::get('modules/{name}/{id}', 'TypesController@show')->name('jelly-module');
        Route::post('modules/{name}/{id}', 'TypesController@store');
        Route::post('modules-remove/{name}/{id}', 'TypesController@destroy')->name('jelly-content-remove');

        // Admin stuff.
        Route::group(['middleware'=>'Pinkwhale\Jellyfish\Middleware\IsAdmin'], function () {

            // Types routes.
            Route::get('administrator', 'AdminController@redirect')->name('jelly-admin');
            Route::get('administrator/types', 'AdminController@index_types')->name('jelly-admin-types');
            Route::get('administrator/types/{type}', 'AdminController@show_type')->name('jelly-admin-type');
            Route::post('administrator/types-delete/{type}', 'AdminController@destroy_type')->name('jelly-admin-type-delete');
            Route::post('administrator/types/{type}', 'AdminController@store_type');

            // Preferences
            Route::get('administrator/preferences', 'AdminController@show_preferences')->name('jelly-admin-preferences');
            Route::post('administrator/preferences', 'AdminController@store_preferences');

            // Managing Users.
            Route::get('administrator/users', 'AdminController@list_users')->name('jelly-admin-users');
            Route::get('administrator/users/{id}', 'AdminController@list_users')->name('jelly-admin-user');
            Route::get('administrator/users/{id}', 'AdminController@show_user')->name('jelly-admin-user');
            Route::post('administrator/user-delete/{id}', 'AdminController@destroy_user')->name('jelly-admin-user-delete');
            Route::post('administrator/users/{id}', 'AdminController@store_user');
        });
    });
});
