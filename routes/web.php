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

Route::get('/home', 'HomeController@index');
Route::get('/notificaciones', 'HomeController@getNotificaciones');
Route::get('/advanced', 'HomeController@input');
Route::get('test', 'HomeController@test')->name('test');
Route::post('test', 'HomeController@test');
Route::get('menu', 'HomeController@menu');
Route::group(['namespace' => 'Inventario', 'prefix' => 'inventario', 'middleware' => 'auth'], function () {

//    Route::get('/proveedores', 'InventarioController@index');
    Route::resource('proveedores', 'ProveedoresController');

    Route::get('proveedores/{id}/destroy', ['uses' => 'ProveedoresController@destroy', 'as' => 'proveedores.destroy']);
    Route::post('proveedores/{id}/update', ['uses' => 'ProveedoresController@update', 'as' => 'proveedores.update']);

    Route::resource('activo', 'ActivoController');
    Route::get('activo/{id}/destroy', ['uses' => 'ActivoController@destroy', 'as' => 'activo.destroy']);
    Route::post('activo/{id}/update', ['uses' => 'ActivoController@update', 'as' => 'activo.update']);

    Route::get('activo/{id1}/{id2}', ['uses' => 'ActivoController@editinventario', 'as' => 'activo.editinventario']);
    Route::post('activo/{id1}/{id2}/updateinventario', ['uses' => 'ActivoController@updateinventario', 'as' => 'activo.updateinventario']);
    Route::post('cargar/{id1}/{id2}/updateinventario', ['uses' => 'ActivoController@cargarinventario', 'as' => 'cargar.updateinventario']);

    Route::get('reactivos', ['uses' => 'ActivoController@consumir', 'as' => 'activo.reactivo']);
    Route::get('reactivos/edit', ['uses' => 'ActivoController@consumiredit', 'as' => 'activo.reactivo.edit']);
    Route::post('consumir/{id}/updateinventario', ['uses' => 'ActivoController@consumirupdate', 'as' => 'consumir.updateinventario']);
});

