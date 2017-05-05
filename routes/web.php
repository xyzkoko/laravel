<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

Route::group(['namespace' => 'User','middleware' => 'auth.rule'], function(){
    Route::get('user', 'UserController@index')->name('user');
    Route::any('user/add', 'UserController@add')->name('user/add');
    Route::any('user/update/{id}', 'UserController@update')->name('user/update');
    Route::delete('user/delete/{id}', 'UserController@delete')->name('user/delete');

    Route::get('userRole', 'UserRoleController@index')->name('userRole');
    //test
    Route::get('game', 'UserController@index')->name('game');
});




