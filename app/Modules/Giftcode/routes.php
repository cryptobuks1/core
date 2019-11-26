<?php

$namespace = 'App\Modules\Giftcode\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Giftcode', 'namespace' => $namespace], function () {

    Route::get('/giftcode',['as'=>'giftcode.index', 'uses'=>'GiftcodeController@index']);
    Route::get('/giftcode/create','GiftcodeController@create');
    Route::post('giftcode/prepaid', ['as'=>'giftcode.prepaid', 'uses'=>'GiftcodeController@deposit']);
    Route::post('giftcode/discount', ['as'=>'giftcode.discount', 'uses'=>'GiftcodeController@discount']);
    Route::post('giftcode/renewservice', ['as'=>'giftcode.renewservice', 'uses'=>'GiftcodeController@renewal']);
    Route::post('giftcode/buyservice', ['as'=>'giftcode.buyservice', 'uses'=>'GiftcodeController@purchase']);
    Route::get('giftcode/{id}','GiftcodeController@destroy');
    Route::post('giftcode/fillterSKU','GiftcodeController@fillterSKU');
    Route::post('exportCode','GiftcodeController@exportCode');
});

Route::group(['middleware' => ['web'], 'module'=>'Giftcode', 'namespace' => $namespace], function () {

    Route::get('giftcode','GiftcodeFrontController@index');
    Route::post('giftcode', ['as'=>'frontend.giftcode.redeem', 'uses'=>'GiftcodeFrontController@redeem']);

});