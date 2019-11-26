<?php

$namespace = 'App\Modules\Paygate\Controllers';

$as = config('backend.backendRoute');
$middleware = ["web"];
if(env('LOGIN') === true){
    $middleware = ["web",'auth'];
}

//--FRONTEND
Route::group(['middleware' => $middleware, 'module'=>'Paygate', 'namespace' => $namespace], function () {

    Route::get('/payment',['as'=>'paygate.do.payment', 'uses'=> 'PaygateFrontController@payment']);
    Route::match(['get', 'post'],'/payment/callback/{gateway}','PaygateFrontController@callback');
    Route::get('/payment/manual/{orderid}',['as'=>'paygate.manual.payment', 'uses'=> 'PaygateFrontController@bankpayment']);
    Route::get('/payment/vietcombank/{orderid}',['as'=>'paygate.vietcombank.auto', 'uses'=> 'PaygateFrontController@vietcombankauto']);

});




Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Paygate', 'namespace' => $namespace], function () {

	Route::get('list-getaways','PaygateController@listGateway');
	Route::get('test-getaways','PaygateController@test');

    Route::get('paygates',['as' => 'backend.paygates.index','uses' => 'PaygateController@index']);
    Route::get('paygates/{id}/edit','PaygateController@edit')->name('edit.paygate.admin');
    Route::delete('paygates/{id}','PaygateController@delete');
    Route::patch('paygates/{id}/update',['as' => 'backend.paygates.update','uses' => 'PaygateController@update']);

    Route::get('paygates/add/{code}',['as' => 'backend.paygates.addpaygate','uses' => 'PaygateController@addpaygate']);
    Route::post('paygates/add',['as' => 'backend.paygates.addpaygate','uses' => 'PaygateController@postaddpaygate']);

});