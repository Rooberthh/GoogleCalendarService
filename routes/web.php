<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version() . ' ' . env('APP_NAME');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('events',  ['uses' => 'EventsController@index']);
    $router->post('events',  ['uses' => 'EventsController@store']);
    $router->patch('events/{id}',  ['uses' => 'EventsController@update']);
    $router->delete('events/{id}',  ['uses' => 'EventsController@destroy']);
});