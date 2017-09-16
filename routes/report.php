<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'reportes', 'middleware' => ['permission:admin_users']], function () {

    Route::get('/', 'ReportController@index')->name('report');
    Route::get('recolector', 'ReportController@recolector')->name('report.recolector');
    Route::post('recolector', 'ReportController@rpt_recolector')->name('report.recolector');
});