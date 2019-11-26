<?php

$namespace = 'App\Modules\Affiliate\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Affiliate', 'namespace' => $namespace], function () {

    Route::get('/affiliates', ['as'=>'admin.affiliate.index', 'uses'=>'AffiliateController@index']);
    Route::get('/affiliates/setting', ['as'=>'admin.affiliate.setting', 'uses'=>'AffiliateController@setting']);
    Route::post('/affiliates/setting', ['as'=>'admin.affiliate.setting', 'uses'=>'AffiliateController@postsetting']);

});

///API không cần đăng nhập
Route::group(['middleware' => ['web'], 'module'=>'Affiliate', 'namespace' => $namespace], function () {

    Route::get('/account/affiliate/test', ['as'=>'user.affiliate.test', 'uses'=>'AffiliateFrontController@test']);

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/account/affiliate', ['as'=>'user.affiliate.list', 'uses'=>'AffiliateFrontController@index']);
        Route::get('/account/affiliate/users', ['as'=>'frontend.affiliate.users', 'uses'=>'AffiliateFrontController@affusers']);

    });

});
