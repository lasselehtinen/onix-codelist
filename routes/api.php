<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('/v1/codelist', 'App\Api\V1\Controllers\OnixCodelistController@index');
    $api->get('/v1/codelist/{number}', 'App\Api\V1\Controllers\OnixCodelistController@show');
});
