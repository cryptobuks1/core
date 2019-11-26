<?php

$namespace = 'App\Modules\Order\Controllers';

$as = config('backend.backendRoute');
$middleware = ["web"];
if(env('LOGIN') === true){
    $middleware = ["web",'auth'];
}

//--FRONTEND
Route::group(['middleware' => $middleware, 'module'=>'Order', 'namespace' => $namespace], function () {
    Route::get('/checkout',['as'=>'frontend.order.checkout', 'uses'=>'OrderFrontController@viewPageCheckout']);
    Route::post('checkout',['as'=>'frontend.order.dopayment', 'uses'=>'OrderFrontController@doPayment']);
    ////Mới
    Route::get('order/detail/{order_code}',['as'=>'frontend.order.detail.page', 'uses'=>'OrderFrontController@orderDetail']);
});


//Backend
Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Order', 'namespace' => $namespace], function () {
    Route::get('/orders','OrderController@index')->name('orders.backend.total');
    Route::get('ajax/withdraw/{id}', 'OrderController@ajaxWithdrawContent');
    Route::post('ajax/withdraw/{id}', ['as' => 'ajax.withdraw.approve', 'uses' =>'OrderController@withdrawAjaxApprove']);

    Route::get('ajax/deposit/{id}', 'OrderController@ajaxDepositContent');
    Route::post('ajax/deposit/{id}', ['as' => 'ajax.deposit.approve', 'uses' =>'OrderController@depositAjaxApprove']);
    Route::post('order/{id}/delete', ['as' => 'order.delete.admin', 'uses' =>'OrderController@deleteOrder']);

    Route::get('ajax/wallethistory/{id}', 'OrderController@userWalletHistory');

});


