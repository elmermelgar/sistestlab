<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');
Route::get('notificaciones', 'HomeController@getNotificaciones');
Route::get('advanced', 'HomeController@input');
Route::get('menu', 'HomeController@menu');
Route::get('test', 'HomeController@test')->name('test');
Route::post('test', 'HomeController@test');

