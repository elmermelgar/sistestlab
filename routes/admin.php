<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'usuarios', 'middleware' => ['permission:admin_users']], function () {

    Route::get('/', 'UserController@index');
    Route::post('enable', 'UserController@enable');
    Route::post('disable', 'UserController@disable');
    Route::get('create', 'UserController@create');
    Route::get('{id}', 'UserController@show');
    Route::get('{id}/edit', 'UserController@edit');
    Route::post('store', 'UserController@store');
});

Route::get('/usuario/perfil', 'UserController@show');
Route::get('/usuario/editar', 'UserController@edit');

Route::group(['prefix' => 'roles', 'middleware' => ['permission:admin_roles']], function () {

    Route::get('/', 'RoleController@index');
    Route::get('create', 'RoleController@create');
    Route::get('{id}/', 'RoleController@show');
    Route::get('{id}/edit', 'RoleController@edit');
    Route::post('store', 'RoleController@store');
    Route::post('delete', 'RoleController@delete');
    Route::post('postPerms', 'RoleController@postPerms');
});

Route::group(['prefix' => 'permisos', 'middleware' => ['permission:admin_permissions']], function () {

    Route::get('/', 'PermissionController@index');
    Route::get('{id}/edit', 'PermissionController@edit');
    Route::post('store', 'PermissionController@store');
});

Route::group(['prefix' => 'sucursal'], function () {
    Route::get('/', 'SucursalController@show');

    Route::group(['prefix'=>'caja','middleware' => ['permission:admin_caja']], function () {
        Route::post('abrir', 'SucursalController@abrirCaja');
        Route::post('cerrar', 'SucursalController@cerrarCaja');
    });
});

Route::group(['prefix' => 'sucursales', 'middleware' => ['permission:admin_sucursales']], function () {

    Route::get('/', 'SucursalController@index');
    Route::get('create', 'SucursalController@create');
    Route::get('{id}', 'SucursalController@show');
    Route::get('{id}/edit', 'SucursalController@edit');
    Route::get('{id}/image', 'SucursalController@image');
    Route::post('image/', 'SucursalController@changeImage');
    Route::post('store', 'SucursalController@store');
});

Route::group(['prefix' => 'imagenes', 'middleware' => ['permission:admin_imagenes']], function () {

    Route::get('/', 'ImagenController@index');
    Route::get('upload', 'ImagenController@upload');
    Route::get('{id}/edit', 'ImagenController@edit');
    Route::post('delete', 'ImagenController@delete');
    Route::post('store', 'ImagenController@store');


    Route::group(['prefix' => 'categorias'], function () {

        Route::get('/', 'ImagenCategoriaController@index');
        Route::get('create', 'ImagenCategoriaController@create');
        Route::get('{id}/edit', 'ImagenCategoriaController@edit');
        Route::post('delete', 'ImagenCategoriaController@delete');
        Route::post('store', 'ImagenCategoriaController@store');

    });

});

Route::group(['prefix' => 'clientes', 'middleware' => ['permission:admin_clientes']], function () {

    Route::get('/', 'ClienteController@index');
    Route::get('create', 'ClienteController@create');
    Route::get('{id}', 'ClienteController@show');
    Route::get('{id}/edit', 'ClienteController@edit');
    Route::post('delete', 'ClienteController@delete');
    Route::post('store', 'ClienteController@store');
});

Route::group(['prefix' => 'pacientes', 'middleware' => ['permission:admin_pacientes']], function () {

    Route::get('/', 'PacienteController@index');
    Route::get('create', 'PacienteController@create');
    Route::get('{id}', 'PacienteController@show');
    Route::get('{id}/edit', 'PacienteController@edit');
    Route::post('delete', 'PacienteController@delete');
    Route::post('store', 'PacienteController@store');
});
