<?php

/*
|--------------------------------------------------------------------------
| Item Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'json/items'], function(){
	Route::get('','ItemController@all');
	Route::get('{item}','ItemController@one');
	Route::post('','ItemController@store');
	Route::put('{item}','ItemController@update');
	Route::delete('{item}','ItemController@destroy');
});
Route::resource('items','ItemController', [
	'only' => [
		'index'
	]
]);