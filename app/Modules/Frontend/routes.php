<?php

$namespace = 'App\Modules\Frontend\Controllers';
$middleware = ["web"];
if(env('LOGIN') === true){
    $middleware = ["web",'auth'];
}
Route::group(['middleware' =>['web'] , 'module'=>'Frontend', 'namespace' => $namespace], function () {
    Route::get('userlogin/{id}/{token}','FrontendController@userlogin');

});

Route::group(['middleware' => $middleware, 'module'=>'Frontend', 'namespace' => $namespace], function () {

    Route::get('/', ['as' =>'home', 'uses' =>'FrontendController@index']);
    Route::get('/change-currency', ['as' =>'home.change.currency', 'uses' =>'FrontendController@postSetSiteCurrency']);

    /* change site's language */
    Route::get('/change-lang', 'FrontendController@postSetSiteLang');

    ////Front area
    Route::get('/reset-password',['as'=>'reset-password', 'uses'=> 'FrontendController@password_reset']);

    Route::post('/password/resetsms', ['as' => 'password.phone', 'uses' =>'FrontendController@resetPasswordSms']);
    Route::get('/password/resetsms/confirm', ['as' => 'password.phone.confirm', 'uses' =>'FrontendController@resetPasswordSmsConfirm']);
    Route::post('/password/resetsms/post', ['as' => 'password.phone.post', 'uses' =>'FrontendController@resetPasswordSmsPost']);

    //// Login with social
    Route::get('/auth/{provider}', 'SocialiteController@redirectToprovider');
    Route::get('auth/callback/{provider}', 'SocialiteController@callbackFromprovider');

});

