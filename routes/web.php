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
    //用户列表
    Route::get('user/index', 'UserController@index')->name('user.index');
    Route::any('user/create', 'UserController@create')->name('user.create');
    Route::any('user/{id}/update', 'UserController@update')->name('user.update');
    Route::delete('user/{id}/destroy', 'UserController@destroy')->name('user.destroy');
    //用户组列表
    Route::resource('userRole', 'UserRoleController');
});





