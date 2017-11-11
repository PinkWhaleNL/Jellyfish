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

        // Media
        Route::get('media', 'MediaController@index')->name('jelly-media');
        Route::get('media/{id}', 'MediaController@show')->name('jelly-media-show');
        Route::post('media/{id}', 'MediaController@store');
        Route::post('media-remove/{id}', 'MediaController@destroy')->name('jelly-media-remove');

        // Modules.
        Route::get('modules/{name}', 'TypesController@index')->name('jelly-modules');
        Route::get('modules/{name}/{id}', 'TypesController@show')->name('jelly-module');
        Route::post('modules/{name}/{id}', 'TypesController@store');

        Route::group(['middleware'=>'Pinkwhale\Jellyfish\Middleware\IsAdmin'], function(){
            Route::get('administrator','AdminController@redirect')->name('jelly-admin');
            Route::get('administrator/types','AdminController@index_types')->name('jelly-admin-types');
            Route::get('administrator/types/{type}','AdminController@show_type')->name('jelly-admin-type');
            Route::post('administrator/types-delete/{type}','AdminController@destroy_type')->name('jelly-admin-type-delete');
            Route::post('administrator/types/{type}','AdminController@store_type');
        });

    });

});