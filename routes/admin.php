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
    Route::get('/view', 'SucursalController@view');
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

Route::group(['prefix' => 'origenes', 'middleware' => ['permission:admin_origenes']], function () {

    Route::get('/', 'CentroOrigenController@index');
    Route::get('create', 'CentroOrigenController@create');
    Route::get('{id}', 'CentroOrigenController@show');
    Route::get('{id}/edit', 'CentroOrigenController@edit');
    Route::post('delete', 'CentroOrigenController@delete');
    Route::post('store', 'CentroOrigenController@store');
});


Route::group(['prefix' => 'examenes', 'middleware' => ['permission:admin_pacientes']], function () {

    Route::resource('/','ExamController');
    Route::get('/{id}', 'ExamController@index');
    Route::get('/{id1}/{id2}', 'ExamController@detail');
    Route::get('/examen/{id}/create', 'ExamController@create');
    Route::get('/examen/{id}/edit',['uses'=>'ExamController@edit', 'as'=>'examenes.edit']);
    Route::get('/examen/{id}/create_detail',['uses'=>'ExamController@create_detail', 'as'=>'examenes.create_detail']);
    Route::get('/examen/{id}/create_resources',['uses'=>'ExamController@create_resources', 'as'=>'examenes.create_resources']);
    Route::get('/examen/{id}/{id2}/edit_detail',['uses'=>'ExamController@edit_detail', 'as'=>'examenes.edit_detail']);
    Route::get('/examen/{id}/{id2}/delete_detail',['uses'=>'ExamController@destroy_detail', 'as'=>'examenes.destroy_detail']);
    Route::get('/examen/{id}/{id2}/delete_group',['uses'=>'ExamController@destroy_group', 'as'=>'examenes.destroy_group']);
    Route::get('/examen/{id}/{id2}/{id3}/delete_reference',['uses'=>'ExamController@destroy_reference', 'as'=>'examenes.destroy_reference']);
    Route::get('/examen/{id}/{id2}/reference_value',['uses'=>'ExamController@reference_detail', 'as'=>'examenes.reference_value']);
    Route::post('/examen/storegrupo', 'ExamController@storegroup');
    Route::post('/examen/storedetail', 'ExamController@storedetail');
    Route::post('/examen/storereference', 'ExamController@storereference');
    Route::post('/examen/store_examen_activo', 'ExamController@store_examen_activo');

});