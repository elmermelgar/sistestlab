<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|root']], function () {

    Route::group(['prefix' => 'usuarios', 'middleware' => ['permission:admin_users']], function () {

        Route::get('/', 'UserController@index');
    });

    Route::group(['prefix' => 'roles', 'middleware' => ['permission:admin_roles']], function () {

        Route::get('/','RoleController@index');
    });

    Route::group(['prefix' => 'permisos', 'middleware' => ['permission:admin_permissions']], function () {

        Route::get('/', 'PermissionController@index');
    });


});
