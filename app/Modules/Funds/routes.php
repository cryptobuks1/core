<?php

$namespace = 'App\Modules\Funds\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Funds', 'namespace' => $namespace], function () {
    Route::group(['prefix' => 'fund'], function () {
        //Funds
        Route::get('/index','FundController@index')->name('fund.index');
        Route::get('/create','FundController@create')->name('fund.create');
        Route::POST('/store','FundController@store')->name('fund.store');
        Route::get('/edit/{id}','FundController@edit')->name('fund.edit');
        Route::PATCH('/update/{id}','FundController@update')->name('fund.update');
        Route::delete('/delete/{id}','FundController@destroy')->name('fund.destroy');

        //Fund-Trans
        Route::get('/trans','FundController@getFundTrans')->name('fund-trans.get');
        Route::post('/trans','FundController@postFundTrans')->name('fund-trans.post');
        Route::get('/list-order','FundController@listOrder')->name('fund-trans.order');
        Route::get('/order/edit/{id}','FundController@editOrder')->name('fund-trans.edit');
        Route::PATCH('/order/update/{id}','FundController@updateOrder')->name('fund-trans.update');
        Route::delete('/order/delete/{id}','FundController@deleteOrder')->name('fund-trans.delete');

        Route::get('/order/print/{id}','FundController@Inprint')->name('fund-trans.print');

        //Reason
        Route::group(['prefix' => 'reason'], function () {
            Route::get('/index','FundController@reasonIndex')->name('reason.index');
            Route::get('/create','FundController@reasonCreate')->name('reason.create');
            Route::POST('/store','FundController@reasonSorte')->name('reason.store');
            Route::get('/edit/{id}','FundController@reasonEdit')->name('reason.edit');
            Route::PATCH('/update/{id}','FundController@reasonUpdate')->name('reason.update');
            Route::delete('/delete/{id}','FundController@reasonDelete')->name('reason.destroy');
        });
        //ajax
        Route::POST('/ajax/bank-name','FundController@ajaxBankName')->name('ajax.bank_name');
        Route::POST('/ajax/bank-num','FundController@ajaxBankNum')->name('ajax.bank_num');

        Route::POST('/ajax/name','FundController@ajaxFundName')->name('ajax.fund.name');
        Route::POST('/ajax/fund/infouser','FundController@ajaxInfoUser')->name('ajax.infouser');
        Route::POST('/ajax/fund/reason','FundController@ajaxFundReason')->name('ajax.fund.reason');
        Route::POST('/ajax/fund/currency','FundController@ajaxFundCurrency')->name('ajax.currency');
        Route::POST('/ajax/fund/type','FundController@ajaxFundType')->name('ajax.fund.type');
        Route::POST('/ajax/fund/number','FundController@ajaxFundNumber')->name('ajax.fund.number');


    });
    Route::GET('/inventory/search/sender','FundController@ajaxSender');
    Route::GET('/inventory/search/receiver','FundController@ajaxReceiver');
});
