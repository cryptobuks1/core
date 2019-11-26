<?php

$namespace = 'App\Modules\Api\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Api', 'namespace' => $namespace], function () {

});

///API không cần đăng nhập
Route::group(['middleware' => ['web'], 'module'=>'Api', 'namespace' => $namespace], function () {
    Route::post('/api/apps/userlogin', 'AppUserController@appUserLogin');
    Route::post('/api/apps/userregister', 'AppUserController@appUserRegister');

    Route::post('/api/apps/getdefault', 'AppSiteController@getdefault');
    Route::post('/api/apps/getmenu', 'AppSiteController@getmenu');
    Route::post('/api/apps/getsliders', 'AppSiteController@getsliders');
    Route::post('/api/apps/getblocknews', 'AppSiteController@getblocknews');
    Route::post('/api/apps/getlistnews', 'AppSiteController@getlistnews');
});

///API cần đăng nhập
Route::group(['middleware' => ['auth:api'], 'module'=>'Api', 'namespace' => $namespace], function () {

    Route::post('/api/apps/userlogout', 'AppUserController@appUserLogout');
    Route::get('/api/apps/userprofile', 'AppUserController@appUserProfile');
    Route::post('/api/apps/userchangepass', 'AppUserController@appUserChangePassword');
    Route::post('/api/apps/userupdate', 'AppUserController@appUserUpdate');
    Route::post('/api/apps/userinfo', 'AppUserController@appUserInfo');
    Route::post('/api/apps/getname', 'AppUserController@appGetName');

    ///Ví điện tử
    Route::post('/api/apps/wallethistory', 'AppWalletController@appWalletHistory');
    Route::post('/api/apps/wallettransfer', 'AppWalletController@appWalletTransfer');



});
