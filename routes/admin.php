<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------|
*/

    Route::group(['prefix' => 'usuarios', 'middleware' => ['permission:admin_users']], function () {

        Route::get('/', 'UserController@index');
        Route::get('show/{id}', 'UserController@show');
    });

    Route::group(['prefix' => 'roles', 'middleware' => ['permission:admin_roles']], function () {

        Route::get('/','RoleController@index');
        Route::get('create','RoleController@create');
        Route::get('show/{id}','RoleController@show');
        Route::get('edit/{id}','RoleController@edit');
        Route::post('store','RoleController@store');
        Route::post('postPerms','RoleController@postPerms');
    });

    Route::group(['prefix' => 'permisos', 'middleware' => ['permission:admin_permissions']], function () {

        Route::get('/', 'PermissionController@index');
        Route::get('edit/{id}', 'PermissionController@edit');
        Route::post('store', 'PermissionController@store');
    });

Route::get('/usuario/perfil','Admin\UserController@show');
