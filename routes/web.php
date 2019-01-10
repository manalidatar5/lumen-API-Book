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
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('register','UserController@register');

    $router->get('getbooks/{user_id}','UserController@getbooks');

    $router->get('books', ['middleware' => 'auth','uses' => 'BookController@showAllBooks']);

    $router->get('books/{id}', ['uses' => 'BookController@showOneBook']);

    $router->post('books', ['uses' => 'BookController@create']);

    $router->delete('books/{id}', ['uses' => 'BookController@delete']);

    $router->put('books/{id}', ['uses' => 'BookController@update']);

});