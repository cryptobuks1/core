<?php

$namespace = 'App\Modules\Sms\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Sms', 'namespace' => $namespace], function () {

    Route::get('/sms', ['as'=>'backend.sms.log', 'uses'=> 'SmsController@index']);
    Route::get('/sms/provider', ['as'=>'backend.sms.provider', 'uses'=> 'SmsController@provider']);
    Route::get('sms/provider/{id}/update', ['as'=>'backend.sms.provider.update', 'uses'=>'SmsController@updatesetting']);
    Route::patch('sms/provider/{id}/update', ['as'=>'backend.sms.provider.update', 'uses'=>'SmsController@postupdatesetting']);
    Route::get('sms/install/{name}', ['as'=>'sms.provider.install', 'uses'=>'SmsController@install']);
    Route::post('sms/action', ['as'=>'sms.provider.action', 'uses'=>'SmsController@action']);

    Route::resource('/sms','SmsController');

});


Route::group(['middleware' => ['web'], 'module'=>'Sms', 'namespace' => $namespace], function () {
    ///API dang ky
    Route::post('/api/Vmg/callback', 'SmsFrontController@dangkysms');
});
