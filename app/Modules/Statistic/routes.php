<?php

$namespace = 'App\Modules\Statistic\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Statistic', 'namespace' => $namespace], function () {

    Route::get('/statistic/charging',['as'=>'statistic.charging', 'uses'=> 'StatisticController@chargingstat']);
    Route::get('/statistic/softcard',['as'=>'statistic.softcard', 'uses'=> 'StatisticController@softcardstat']);
    Route::get('/statistic/stockcard',['as'=>'statistic.stockcard', 'uses'=> 'StatisticController@stockcardstat']);
    Route::get('/statistic/withdraw',['as'=>'statistic.withdraw', 'uses'=> 'StatisticController@withdrawstat']);
    Route::get('/statistic/deposit',['as'=>'statistic.deposit', 'uses'=> 'StatisticController@depositstat']);
    Route::get('/statistic/mtopup',['as'=>'statistic.mtopup', 'uses'=> 'StatisticController@mtopupstat']);
    Route::get('/statistic/wallet',['as'=>'statistic.wallet', 'uses'=> 'StatisticController@walletstat']);
    Route::get('/statistic/dailystat',['as'=>'statistic.dailystat', 'uses'=> 'StatisticController@dailystat']);




});


Route::group(['middleware' => ['web'], 'module'=>'Statistic', 'namespace' => $namespace], function () {


});
