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
    Route::get('registry', 'SucursalController@registry');

    Route::group(['prefix' => 'caja', 'middleware' => ['permission:admin_caja']], function () {
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
    Route::get('{id}/registry', 'SucursalController@registry');
    Route::get('{id}/facturas', 'FacturaController@index');
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

Route::group(['prefix' => 'bonos', 'middleware' => ['permission:admin_bonos']], function () {

    Route::get('/', 'BonoController@index');
    Route::get('create', 'BonoController@create');
    Route::get('{id}/edit', 'BonoController@edit');
    Route::post('delete', 'BonoController@delete');
    Route::post('store', 'BonoController@store');
});

Route::group(['prefix' => 'niveles', 'middleware' => ['permission:admin_niveles']], function () {

    Route::get('/', 'NivelController@index');
    Route::get('create', 'NivelController@create');
    Route::get('{id}/edit', 'NivelController@edit');
    Route::post('delete', 'NivelController@delete');
    Route::post('store', 'NivelController@store');
});

Route::group(['prefix' => 'examenes', 'middleware' => ['permission:admin_examenes']], function () {

    Route::get('/', 'ExamController@index');
    Route::get('create', 'ExamController@create');
    Route::get('{id}', 'ExamController@detail');
    Route::get('{id}/edit', ['uses' => 'ExamController@edit', 'as' => 'examenes.edit']);
    Route::get('{id}/create_detail', ['uses' => 'ExamController@create_detail', 'as' => 'examenes.create_detail']);
    Route::get('{id}/create_resources', ['uses' => 'ExamController@create_resources', 'as' => 'examenes.create_resources']);
    Route::get('{exam_id}/edit_detail/{exam_detail_id}', ['uses' => 'ExamController@edit_detail', 'as' => 'examenes.edit_detail']);
    Route::get('{exam_id}/delete_detail/{exam_detail_id}', ['uses' => 'ExamController@destroy_detail', 'as' => 'examenes.destroy_detail']);
    Route::get('{exam_id}/reference_value/{exam_detail_id}', ['uses' => 'ExamController@reference_detail', 'as' => 'examenes.reference_value']);
    Route::get('{exam_id}/delete_group/{grouping_id}', ['uses' => 'ExamController@destroy_group', 'as' => 'examenes.destroy_group']);
    Route::get('{exam_id}/{exam_detail_id}/delete_reference/{reference_values_id}', ['uses' => 'ExamController@destroy_reference', 'as' => 'examenes.destroy_reference']);
    Route::post('store', 'ExamController@store');
    Route::post('storegrupo', 'ExamController@storegroup');
    Route::post('storedetail', 'ExamController@storedetail');
    Route::post('storereference', 'ExamController@storereference');
    Route::post('store_examen_activo', 'ExamController@store_examen_activo');

});


Route::group(['prefix' => 'perfiles', 'middleware' => ['permission:admin_perfiles']], function () {
    Route::get('/', 'ProfileController@index');
    Route::get('create', 'ProfileController@create');
    Route::get('{id}', 'ProfileController@show');
    Route::get('{id}/edit', 'ProfileController@edit');
    Route::get('search/exam', 'ProfileController@searchExam');
    Route::post('store', 'ProfileController@store');
    Route::post('store/prices', 'ProfileController@prices');
    Route::post('add_exam', 'ProfileController@add_exam');
    Route::post('del_exam', 'ProfileController@del_exam');
});


Route::group(['prefix' => 'results', 'middleware' => ['permission:admin_examenes']], function () {

    Route::get('/invoice/', 'ResultadosController@index');
    Route::get('/invoice/all', 'ResultadosController@all');
    Route::get('/invoice/process', 'ResultadosController@process');
    Route::get('{id_ex}/{id_xp}/complete', 'ResultadosController@complete');
    Route::post('store/results', 'ResultadosController@results');
    Route::get('/ticket/{id_ex}/{id_xp}', 'ResultadosController@ticket');
    Route::post('storeantibiotico', 'AntibioticosController@storeantibiotico');
    Route::get('antibiotico/{id}', 'AntibioticosController@destroy');
    Route::get('{id}/storeaprobar', 'ResultadosController@storeaprobar');
    Route::post('{id}/storedenegar', 'ResultadosController@storedenegar');
});