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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');

    Route::group(['prefix' => 'json'], function () {
    	Route::get('notifications', 'HomeController@notifications');
    	Route::get('lang/datatable', function () {
    		return response()->json(Lang::get('datatable'));
    	});
    });
});

Auth::routes();
