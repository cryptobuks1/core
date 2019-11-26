<?php

$namespace = 'App\Modules\Twofactor\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Twofactor', 'namespace' => $namespace], function () {

Route::get('twofactor', ['as'=>'twofactor.index', 'uses'=>'TwofactorController@index']);
Route::get('twofactor/delete/{id}', ['as'=>'twofactor.delete', 'uses'=>'TwofactorController@delete2fa']);
});