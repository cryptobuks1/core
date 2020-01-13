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
    Route::group(['prefix'=>'telco'],  function () {
        Route::get('/',               ['as'=>'backend.telco.index', 'uses'=> 'SmsController@telco_index']);
        Route::get('/create',         ['as'=>'backend.telco.create','uses'=> 'SmsController@telco_create']);
        Route::post('/store',         ['as'=>'backend.telco.store', 'uses'=> 'SmsController@telco_store']);
        Route::get('/edit/{id}',      ['as'=>'backend.telco.edit',  'uses'=> 'SmsController@telco_edit']);
        Route::PATCH('/update/{id}',  ['as'=>'backend.telco.update','uses'=> 'SmsController@telco_update']);
        Route::delete('/delete/{id}', ['as'=>'backend.telco.delete','uses'=> 'SmsController@telco_delete']);
    });
    Route::get('/getprice/{user_id}/{telco}/{currency_code}',['as'=>'backend.getprice', 'uses'=> 'SmsController@getPrice']);

});


Route::group(['middleware' => ['web'], 'module'=>'Sms', 'namespace' => $namespace], function () {
    ///API dang ky
    Route::post('/api/Vmg/callback', 'SmsFrontController@dangkysms');
    Route::get('/sms/list/order', ['as'=>'frontend.sms.order',  'uses'=> 'SmsFrontController@listOrderSms']);
});
