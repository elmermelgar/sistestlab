<?php

/*
|--------------------------------------------------------------------------
| Laboratorio Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'clientes', 'middleware' => ['permission:admin_clientes']], function () {

    Route::get('/', 'CustomerController@index')->name('customer');
    Route::get('create', 'CustomerController@create')->name('customer.create');
    Route::get('{id}', 'CustomerController@show')->name('customer.show');
    Route::get('{id}/edit', 'CustomerController@edit')->name('customer.edit');
    Route::post('store', 'CustomerController@store')->name('customer.store');
});

Route::group(['prefix' => 'origenes', 'middleware' => ['permission:admin_clientes']], function () {
    Route::get('/', 'CustomerController@origenes')->name('origin');
});

Route::group(['prefix' => 'pacientes', 'middleware' => ['permission:admin_pacientes']], function () {

    Route::get('/', 'PatientController@index')->name('patient');
    Route::get('create', 'PatientController@create')->name('patient.create');
    Route::get('{id}', 'PatientController@show')->name('patient.show');
    Route::get('{id}/edit', 'PatientController@edit')->name('patient.edit');
    Route::post('delete', 'PatientController@delete')->name('patient.delete');
    Route::post('store', 'PatientController@store')->name('patient.store');
});

Route::group(['prefix' => 'recolectores', 'middleware' => ['permission:admin_recolectores']], function () {

    Route::get('/', 'RecolectorController@index');
    Route::get('create', 'RecolectorController@create');
    Route::get('{id}', 'RecolectorController@show');
    Route::get('{id}/edit', 'RecolectorController@edit');
    Route::post('{id}/bonificar', 'RecolectorController@bonificar');
    Route::post('delete', 'RecolectorController@delete');
    Route::post('store', 'RecolectorController@store');
    Route::post('activar', 'RecolectorController@activar');
    Route::post('desactivar', 'RecolectorController@desactivar');
});

Route::group(['prefix' => 'facturas', 'middleware' => ['permission:facturar']], function () {
    Route::get('/', 'FacturaController@index')->name('factura');
    Route::get('create/{origen?}', 'FacturaController@create')->where('origen', 'origen')->name('factura.create');
    Route::get('{id}', 'FacturaController@show')->name('factura.show');
    Route::get('{id}/edit', 'FacturaController@edit')->name('factura.edit');
    Route::post('store', 'FacturaController@store')->name('factura.store');
    Route::post('annul', 'FacturaController@annul')->name('factura.annul');
    Route::post('facturar', 'FacturaController@facturar')->name('factura.facturar');
    Route::post('{id}/payment', 'FacturaController@payment')->name('factura.payment');
    Route::post('{id}/nivel', 'FacturaController@nivel')->name('factura.nivel');
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
    Route::get('patient', 'SearchController@searchPatient');
    Route::get('exam', 'SearchController@searchExam');
});