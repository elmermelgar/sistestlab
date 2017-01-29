<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'usuarios', 'middleware' => ['permission:admin_users']], function () {

    Route::get('/', 'UserController@index');
    Route::get('create', 'UserController@create');
    Route::get('show/{id}', 'UserController@show');
    Route::get('edit/{id}', 'UserController@edit');
    Route::post('store', 'UserController@store');
});

Route::group(['prefix' => 'roles', 'middleware' => ['permission:admin_roles']], function () {

    Route::get('/', 'RoleController@index');
    Route::get('create', 'RoleController@create');
    Route::get('show/{id}', 'RoleController@show');
    Route::get('edit/{id}', 'RoleController@edit');
    Route::post('store', 'RoleController@store');
    Route::post('postPerms', 'RoleController@postPerms');
});

Route::group(['prefix' => 'permisos', 'middleware' => ['permission:admin_permissions']], function () {

    Route::get('/', 'PermissionController@index');
    Route::get('edit/{id}', 'PermissionController@edit');
    Route::post('store', 'PermissionController@store');
});

Route::get('/usuario/perfil', 'UserController@show');
Route::get('/usuario/editar', 'UserController@edit');


Route::group(['prefix' => 'sucursales', 'middleware' => ['permission:admin_sucursales']], function () {

    Route::get('/', 'SucursalController@index');
    Route::get('create', 'SucursalController@create');
    Route::get('show/{id}', 'SucursalController@show');
    Route::get('edit/{id}', 'SucursalController@edit');
    Route::post('store', 'SucursalController@store');
});

Route::group(['prefix' => 'imagenes', 'middleware' => ['permission:admin_imagenes']], function () {

    Route::get('/', 'ImagenController@index');
    Route::get('upload', 'ImagenController@upload');
    Route::get('show/{id}', 'ImagenController@show');
    Route::get('edit/{id}', 'ImagenController@edit');
    Route::post('delete', 'ImagenController@delete');
    Route::post('store', 'ImagenController@store');
});
