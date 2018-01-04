<?php

/*
|--------------------------------------------------------------------------
| Report Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'reportes', 'middleware' => ['permission:admin_users']], function () {

    Route::get('/', 'ReportController@index')->name('report');
    Route::get('mensajeria', 'ReportController@mensajeria')->name('report.mensajeria');
    Route::post('mensajeria', 'ReportController@rpt_mensajeria')->name('report.mensajeria');
    Route::get('pruebas', 'ReportController@pruebas')->name('report.pruebas');
    Route::post('pruebas', 'ReportController@rpt_pruebas')->name('report.pruebas');
    Route::get('ref_especifica', 'ReportController@ref_especifica')->name('report.ref_especifica');
    Route::post('ref_especifica', 'ReportController@rpt_ref_especifica')->name('report.ref_especifica');
    Route::get('suc_especifica', 'ReportController@suc_especifica')->name('report.suc_especifica');
    Route::post('suc_especifica', 'ReportController@rpt_suc_especifica')->name('report.suc_especifica');
    Route::get('registro', 'ReportController@registro')->name('report.registro');
    Route::post('registro', 'ReportController@rpt_registro')->name('report.registro');
    Route::get('registro_detalle', 'ReportController@registro_detalle')->name('report.registro_detalle');
    Route::post('registro_detalle', 'ReportController@rpt_registro_detalle')->name('report.registro_detalle');
    Route::get('lista_factura', 'ReportController@lista_factura')->name('report.lista_factura');
    Route::post('lista_factura', 'ReportController@rpt_lista_factura')->name('report.lista_factura');
    Route::get('lista_anulada', 'ReportController@lista_anulada')->name('report.lista_anulada');
    Route::post('lista_anulada', 'ReportController@rpt_lista_anulada')->name('report.lista_anulada');
    Route::get('lista_niveles', 'ReportController@lista_niveles')->name('report.lista_niveles');
    Route::post('lista_niveles', 'ReportController@rpt_lista_niveles')->name('report.lista_niveles');
    Route::get('lista_examen', 'ReportController@lista_examen')->name('report.lista_examen');
    Route::post('lista_examen', 'ReportController@rpt_lista_examen')->name('report.lista_examen');
    Route::get('lista_origen', 'ReportController@lista_origen')->name('report.lista_origen');
    Route::post('lista_origen', 'ReportController@rpt_lista_origen')->name('report.lista_origen');
    Route::get('lista_proveedor', 'ReportController@lista_proveedor')->name('report.lista_proveedor');
    Route::post('lista_proveedor', 'ReportController@rpt_lista_proveedor')->name('report.lista_proveedor');
    Route::get('existencias', 'ReportController@existencias')->name('report.existencias');
    Route::post('existencias', 'ReportController@rpt_existencias')->name('report.existencias');
    Route::get('rpt_factura/{factura_id}', 'ReportController@rpt_factura')->name('report.factura');
});