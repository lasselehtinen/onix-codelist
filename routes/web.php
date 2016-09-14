<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
 */

Route::group(['middleware' => ['web']], function () {
    Route::resource('codelist', 'CodelistController', ['only' => ['index', 'show']]);

    Route::get('search', 'CodelistController@search');

    Route::get('/api-docs', function () {
        return response()->view('api-docs');
    });

    Route::get('/about', function () {
        return response()->view('about');
    });

    Route::get('/', function () {
        return redirect()->route('codelist.index');
    });
});
