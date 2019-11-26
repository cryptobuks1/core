<?php

$namespace = 'App\Modules\Localbank\Controllers';
$as = config('backend.backendRoute');

//--FRONTEND
Route::group(['middleware' => ['web'], 'module'=>'Localbank', 'namespace' => $namespace], function () {

    Route::get('/user/localbank',['as'=>'user.localbank', 'uses'=> 'LocalbankFrontController@localbank']);
    Route::post('/user/localbank',['as'=>'user.localbank', 'uses'=> 'LocalbankFrontController@postlocalbank']);
    Route::get('/user/localbank/verify',['as'=>'user.localbank.verify', 'uses'=> 'LocalbankFrontController@localbankverify']);
    Route::post('/user/localbank/verify',['as'=>'user.localbank.verify', 'uses'=> 'LocalbankFrontController@postlocalbankverify']);
    Route::delete('/user/localbank/del/{id}',['as'=>'frontend.del.localbank.user', 'uses'=> 'LocalbankFrontController@delmybank']);

});




Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Localbank', 'namespace' => $namespace], function () {

    Route::get('/localbank/delbankuser/{id}', ['as' =>'del.localbank.user', 'uses'=>'LocalbankController@delbankuser']);
    Route::get('/localbank/users','LocalbankController@localbankuser')->name('backend.localbank.user');
    Route::resource('/localbank','LocalbankController');
});