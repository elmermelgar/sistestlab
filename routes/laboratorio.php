<?php

/*
|--------------------------------------------------------------------------
| Laboratorio Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'clientes', 'middleware' => ['permission:admin_clientes']], function () {

    Route::get('/', 'ClienteController@index');
    Route::get('create', 'ClienteController@create');
    Route::get('{id}', 'ClienteController@show');
    Route::get('{id}/edit', 'ClienteController@edit');
    Route::post('delete', 'ClienteController@delete');
    Route::post('store', 'ClienteController@store');
});

Route::group(['prefix' => 'origenes', 'middleware' => ['permission:admin_clientes']], function () {
    Route::get('/', 'ClienteController@origenes');
});

Route::group(['prefix' => 'pacientes', 'middleware' => ['permission:admin_pacientes']], function () {

    Route::get('/', 'PacienteController@index');
    Route::get('create', 'PacienteController@create');
    Route::get('{id}', 'PacienteController@show');
    Route::get('{id}/edit', 'PacienteController@edit');
    Route::post('delete', 'PacienteController@delete');
    Route::post('store', 'PacienteController@store');
});

Route::group(['prefix' => 'recolectores', 'middleware' => ['permission:admin_recolectores']], function () {

    Route::get('/', 'RecolectorController@index');
    Route::get('create', 'RecolectorController@create');
    Route::get('{id}', 'RecolectorController@show');
    Route::get('{id}/edit', 'RecolectorController@edit');
    Route::post('{id}/bonificar', 'RecolectorController@bonoficar');
    Route::post('delete', 'RecolectorController@delete');
    Route::post('store', 'RecolectorController@store');
});

Route::group(['prefix' => 'facturar', 'middleware' => ['permission:facturar']], function () {

    Route::get('/', 'FacturaController@facturar_centro_origen');
    Route::get('/search/customer', 'FacturaController@searchCustomer');
    Route::get('/search/exam', 'FacturaController@searchExam');
});

Route::group(['prefix' => 'facturas', 'middleware' => ['permission:facturar']], function () {
    Route::get('/', 'FacturaController@index');
    Route::get('{id}', 'FacturaController@show');
    Route::get('{id}/edit', 'FacturaController@edit');
    Route::post('store', 'FacturaController@store');
    Route::post('{id}/facturar', 'FacturaController@facturar');
});