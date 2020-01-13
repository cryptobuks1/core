<?php

$namespace = 'App\Modules\Api\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Api', 'namespace' => $namespace], function () {
    Route::get('inet/checkdomain/{domain}','INetController@checkDomain');
    Route::get('inet/searchdomain/{domain}','INetController@searchDomain');
    Route::get('inet/changednsdomain/{domain}','INetController@changeDNSDomain');
    Route::get('inet/getinfodomain/{domain}','INetController@getInfoDomain');

    Route::get('inet/createdomain/{domain}','INetController@createDomain');
    Route::get('inet/createcontact/{domain}','INetController@createContact');
    Route::get('inet/createemail/{domain}','INetController@emailCreate');
    Route::get('inet/createemailaccount/{domain}','INetController@emailAccountCreate');
    Route::get('inet/updateemailaccount/{domain}','INetController@EmailAccountUpdate');
    Route::get('inet/deleteemailaccount/{domain}','INetController@EmailAccountDelete');



    Route::GET('reseller/checkdomain/{domain}.{tlds}','ResellerController@checkDomain');
    Route::get('reseller/searchcustomerid/{domain}  ','ResellerController@searchCustomerid');
    Route::get('reseller/getinfodns/{domain}','ResellerController@getDNSName');
    Route::get('reseller/getorderid/{domain}','ResellerController@getOrderId');
    Route::get('reseller/changednsdomain/{domain}','ResellerController@changeDNSDomain');

    Route::get('reseller/createContact/{domain}','ResellerController@createContact');
    Route::get('reseller/getcontact/{contactId}','ResellerController@getContact');
    Route::get('reseller/deletecontact/{contactId}','ResellerController@deleteContact');
    Route::get('reseller/getlistcontact/{domain}','ResellerController@getListContact');
    Route::get('reseller/createorder/{domain}','ResellerController@createOrder');
    Route::get('reseller/getanorder/{domain}','ResellerController@getAnOrder');
    Route::get('reseller/addemail/{domain}','ResellerController@addEmail');
    Route::get('reseller/deleteorder/{domain}','ResellerController@deleteAnOrder');

    Route::get('reseller/createemail/','ResellerController@createEmail');
    Route::get('reseller/getemail/','ResellerController@getEmail');
    Route::get('reseller/updateemail/','ResellerController@updateEmail');
    Route::get('reseller/deleteemail/','ResellerController@deleteEmail');
    Route::get('reseller/changepassemail/','ResellerController@changePassEmail');

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
