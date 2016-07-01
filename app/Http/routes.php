<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => 'App\Http\Middleware\CORS'], function ($api) {
    $api->get('', 'App\Http\Controllers\Api\NotesController@welcome');
    $api->get('notes', 'App\Http\Controllers\Api\NotesController@index');
    $api->post('notes', 'App\Http\Controllers\Api\NotesController@store');
    $api->get('notes/{id}', 'App\Http\Controllers\Api\NotesController@show');
    $api->put('notes', 'App\Http\Controllers\Api\NotesController@update');
    $api->delete('notes/{id}', 'App\Http\Controllers\Api\NotesController@destroy');
});
