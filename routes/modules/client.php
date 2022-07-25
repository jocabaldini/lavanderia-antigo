<?php

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'json/clients'], function(){
	Route::get('','ClientController@all');
	Route::get('{client}','ClientController@one');
	Route::post('','ClientController@store');
	Route::put('{client}','ClientController@update');
	Route::delete('{client}','ClientController@destroy');
	Route::group(['prefix' => 'payment'], function(){
		Route::post('','ClientController@payment');
		Route::put('{payment}','ClientController@payment');
		Route::get('{payment}','ClientController@editPayment');
	});
});

Route::resource('clients','ClientController', [
	'only' => [
		'index', 'show', 'create', 'edit'
	]
]);