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
    Route::post('activar', 'RecolectorController@activar');
    Route::post('desactivar', 'RecolectorController@desactivar');
});

Route::group(['prefix' => 'facturas', 'middleware' => ['permission:facturar']], function () {
    Route::get('/', 'FacturaController@index');
    Route::get('create/{origen?}', 'FacturaController@create')->where('origen', 'origen');
    Route::get('{id}', 'FacturaController@show');
    Route::get('{id}/edit', 'FacturaController@edit')->name('factura_edit');
    Route::post('store', 'FacturaController@store');
    Route::post('annul', 'FacturaController@annul')->name('factura_annul');
    Route::post('{id}/facturar', 'FacturaController@facturar');
    Route::post('{id}/payment', 'FacturaController@payment');
});

Route::group(['prefix' => 'creditofiscal', 'middleware' => ['permission:credito_fiscal']], function () {
    Route::get('/', 'CreditoFiscalController@index')->name('credito_fiscal.index');
    Route::get('clientes', 'CreditoFiscalController@customers')->name('credito_fiscal.customers');
    Route::get('create/{cliente_id}', 'CreditoFiscalController@create')->name('credito_fiscal.create');
    Route::get('{id}', 'CreditoFiscalController@show')->name('credito_fiscal.show');
    Route::get('{id}/edit', 'CreditoFiscalController@edit')->name('credito_fiscal.edit');
    Route::post('store', 'CreditoFiscalController@store')->name('credito_fiscal.store');
    Route::post('close', 'CreditoFiscalController@close')->name('credito_fiscal.close');
});

Route::group(['prefix' => 'search', 'middleware' => ['permission:facturar']], function () {
    Route::get('customer', 'SearchController@searchCustomer');
    Route::get('profile', 'SearchController@searchProfile');
    Route::get('paciente', 'SearchController@searchPaciente');
});