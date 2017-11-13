<?php 

/**
 * You may define custom routes for your package here
 */

Route::get('/media/picture/{unique}', 'Pinkwhale\Jellyfish\Controllers\MediaController@displayPicture')->name('media-picture');
Route::get('/media/file/{unique}', 'Pinkwhale\Jellyfish\Controllers\Admin\MediaController@displayFile')->name('media');

Route::group(['middleware'=>'web', 'namespace'=>'Pinkwhale\Jellyfish\Controllers','prefix'=>config('jf.slug')],function(){

    Route::redirect('/',config('jf.slug').'/dashboard');
    // Auth.
    Route::resource('login', 'AuthController');
    Route::get('logout', 'AuthController@logout')->name('jelly-logout');
    Route::group(['middleware'=>'Pinkwhale\Jellyfish\Middleware\Auth'],function(){

        Route::get('dashboard', 'DashboardController@show')->name('jelly-dashboard');

        // Language
        Route::get('translations','TranslationsController@index')->name('jelly-translations');
        Route::get('translations/new','TranslationsController@create')->name('jelly-translation-create');
        Route::post('translations/new','TranslationsController@store');
        Route::get('translations/{id}','TranslationsController@show')->name('jelly-translation');
        Route::post('translation-item/{id}','TranslationsController@store_item')->name('jelly-translation-item');
        Route::post('translation-item-remove/{id}','TranslationsController@destroy_item')->name('jelly-translation-item-remove');
        Route::post('translations-remove/{id}','TranslationsController@destroy')->name('jelly-translation-remove');

        // Media
        Route::get('media', 'MediaController@index')->name('jelly-media');
        Route::get('media/{id}', 'MediaController@show')->name('jelly-media-show');
        Route::post('media/{id}', 'MediaController@store');
        Route::post('media-remove/{id}', 'MediaController@destroy')->name('jelly-media-remove');

        // Modules.
        Route::get('modules/{name}', 'TypesController@index')->name('jelly-modules');
        Route::get('modules/{name}/{id}', 'TypesController@show')->name('jelly-module');
        Route::post('modules/{name}/{id}', 'TypesController@store');
        Route::post('modules-remove/{name}/{id}', 'TypesController@destroy')->name('jelly-content-remove');

        Route::group(['middleware'=>'Pinkwhale\Jellyfish\Middleware\IsAdmin'], function(){
            Route::get('administrator','AdminController@redirect')->name('jelly-admin');
            Route::get('administrator/types','AdminController@index_types')->name('jelly-admin-types');
            Route::get('administrator/types/{type}','AdminController@show_type')->name('jelly-admin-type');
            Route::post('administrator/types-delete/{type}','AdminController@destroy_type')->name('jelly-admin-type-delete');
            Route::post('administrator/types/{type}','AdminController@store_type');
        });

    });

});