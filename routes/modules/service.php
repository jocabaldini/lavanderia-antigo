<?php

/*
|--------------------------------------------------------------------------
| Service Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'json/services'], function () {
	Route::get('service-item', 'ServiceController@serviceItem');

	Route::get('', 'ServiceController@all');
	Route::post('', 'ServiceController@store');

	Route::group(['prefix' => '{service}'], function () {
		Route::get('', 'ServiceController@one');
		Route::put('', 'ServiceController@update');
		Route::delete('', 'ServiceController@destroy');
		Route::patch('ready', 'ServiceController@ready');
		Route::patch('delivery', 'ServiceController@delivery');
	});
});

Route::resource('services', 'ServiceController', [
	'only' => [
		'index'
	]
]);