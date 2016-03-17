<?php

use App\Codelist;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('codelist', 'CodelistController', ['only' => ['index', 'show']]);

Route::get('search', 'CodelistController@search');

Route::get('/', function () {
    return redirect()->route('codelist.index');
});

// API routes

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('/v1/codelist', 'App\Api\V1\Controllers\OnixCodelistController@index');
    $api->get('/v1/codelist/{number}', 'App\Api\V1\Controllers\OnixCodelistController@show');
});

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
    //
});
