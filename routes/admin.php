<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'admin'], function () {



    Route::group(['prefix' => 'usuarios'], function () {

        Route::get('/', function () {
            // Matches The "/admin/users" URL
        });
    });


});
