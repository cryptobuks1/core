<?php

$namespace = 'App\Modules\Wallet\Controllers';

$as = config('backend.backendRoute');
$middleware = ["web"];
if(env('LOGIN') === true){
    $middleware = ["web",'auth'];
}
//--FRONTEND
Route::group(['middleware' => $middleware, 'module'=>'Wallet', 'namespace' => $namespace], function () {

    Route::get('/wallet/deposit',['as'=>'frontend.wallet.deposit', 'uses'=> 'WalletFrontController@deposit'] );
    Route::post('/wallet/deposit',['as'=>'frontend.wallet.deposit', 'uses'=> 'WalletFrontController@postdeposit']);
    Route::get('/wallet/deposit/confirm/{orderid}',['as'=>'frontend.wallet.confirmdeposit', 'uses'=> 'WalletFrontController@confirmdeposit']);
    Route::get('/wallet/deposit/cancel/{code}',['as'=>'frontend.wallet.canceldeposit', 'uses'=> 'WalletFrontController@canceldeposit']);

    Route::get('/wallet/withdraw',['as'=>'frontend.wallet.withdraw', 'uses'=> 'WalletFrontController@withdraw'] );
    Route::post('/wallet/withdraw',['as'=>'frontend.wallet.withdraw', 'uses'=> 'WalletFrontController@postwithdraw']);
    Route::get('/wallet/withdraw/confirm',['as'=>'frontend.wallet.confirmwithdraw', 'uses'=> 'WalletFrontController@confirmwithdraw']);


    Route::get('/wallet/list', ['as'=>'user.wallet', 'uses'=>'WalletFrontController@wallet']);

    Route::get('wallet/transfer', ['as'=>'wallet.transfer', 'uses'=>'WalletFrontController@transfer']);
    Route::post('wallet/transfer', ['as'=>'post.wallet.transfer', 'uses'=>'WalletFrontController@posttransfer']);
    Route::post('/transfer/ajax/get-user-name', ['as'=>'ajax.wallet.name', 'uses'=>'WalletFrontController@getusername']);
    Route::post('/transfer/confirm', ['as'=>'post.confirm.wallet.transfer', 'uses'=>'WalletFrontController@postconfirmtransfer']);
    Route::get('/transfer/result/{id}', ['as'=>'wallet.transfer.result', 'uses'=>'WalletFrontController@transferresult']);


});



Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Wallet', 'namespace' => $namespace], function () {
	Route::get('transaction','WalletController@transaction');
	Route::get('transfer-history','WalletController@transferHistory');
	Route::get('transaction/chargeback/{trans_id}','WalletController@chargeBack');
	Route::get('wallets','WalletController@index');
    Route::get('wallet-fees/{code}/edit','WalletController@fees')->name('bk.wallet.updatefee');
    Route::PATCH('wallet-fees/{code}/edit','WalletController@updateFees')->name('bk.wallet.updatefee');
    Route::get('wallet-settings','WalletController@settings');
    Route::post('wallet-create','WalletController@createwallet')->name('bk.wallet.create');
    Route::post('wallet-settings','WalletController@updateSettings');
    Route::get('wallet/orderdeposit','\App\Modules\Order\Controllers\OrderController@orderdeposit')->name('orderdeposit');
    Route::get('wallet/orderwithdraw','\App\Modules\Order\Controllers\OrderController@orderwithdraw')->name('orderwithdraw');


    //Config
    Route::get('wallets/{id}/edit','WalletController@getEditWallet');
    Route::PATCH('wallets/{id}/edit',['as'=>'wallet.postUpdate','uses'=>'WalletController@postUpdateWallet']);

});
