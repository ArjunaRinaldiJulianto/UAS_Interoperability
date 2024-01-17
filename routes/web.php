<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
});

Route::group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/employees', 'EmployeesController@index');
    $router->post('/employees', 'EmployeesController@store');
    $router->get('/employees/{id}', 'EmployeesController@show');
    $router->put('/employees/{id}', 'EmployeesController@update');
    $router->delete('/employees/{id}', 'EmployeesController@destroy');

    $router->get('/attendances', 'AttendancesController@index');
    $router->post('/attendances', 'AttendancesController@store');
    $router->get('/attendances/{id}', 'AttendancesController@show');
    $router->put('/attendances/{id}', 'AttendancesController@update');
    $router->delete('/attendances/{id}', 'AttendancesController@destroy');
});