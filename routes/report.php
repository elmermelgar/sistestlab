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
});