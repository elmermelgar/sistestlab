<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'reportes', 'middleware' => ['permission:admin_users']], function () {

    Route::get('/', 'ReportController@index')->name('report');
    Route::get('mensajeria', 'ReportController@mensajeria')->name('report.mensajeria');
    Route::post('mensajeria', 'ReportController@rpt_mensajeria')->name('report.mensajeria');
    Route::get('referencia', 'ReportController@referencia')->name('report.referencia');
    Route::post('referencia', 'ReportController@rpt_referencia')->name('report.referencia');
    Route::get('ref_especifica', 'ReportController@ref_especifica')->name('report.ref.especifica');
    Route::post('ref_especifica', 'ReportController@rpt_ref_especifica')->name('report.ref.especifica');
    Route::get('suc_especifica', 'ReportController@suc_especifica')->name('report.suc.especifica');
    Route::post('suc_especifica', 'ReportController@rpt_suc_especifica')->name('report.suc.especifica');
});