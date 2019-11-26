<?php

$namespace = 'App\Modules\User\Controllers';

$as = config('backend.backendRoute');

////Backend
Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'User', 'namespace' => $namespace], function () {
    # User Modules
    Route::resource('users','UserController');
    Route::post('users/actions','LoginController@actions');
    Route::get('admins','UserController@admins');
    Route::get('upgrade','UserController@upgrade');
    Route::get('admin/{id}/upgradeUser','UserController@upgradeUser');
    Route::post('admin/updateRole/{id}','UserController@updateRoleUser');

});

///Frontend
Route::group(['middleware' => ['web'], 'module'=>'User', 'namespace' => $namespace], function () {

    $backend_login = config('backend.backendRoute').'/slogin';
    $backend_confirm = config('backend.backendRoute').'/confirm';
    Route::get($backend_login, 'UserFrontController@getLoginAdmin');
    Route::post($backend_login, 'UserFrontController@postLoginAdmin')->name('control.login.admin')->middleware('guest');
    Route::post($backend_confirm, 'UserFrontController@postConfirmAdmin')->name('control.confirm.admin')->middleware('guest');


    Route::get('/account/register',['as'=>'frontend.account.register', 'uses' => 'UserFrontController@create']);
    Route::post('/account/register',['as'=>'frontend.account.store', 'uses' => 'UserFrontController@store']);
    Route::get('/account/login',['as'=>'frontend.account.login', 'uses' => 'UserFrontController@login']);
    Route::post('/account/login',['as'=>'frontend.account.login', 'uses' => 'UserFrontController@postlogin']);
    Route::get('/account/logout',['as'=>'frontend.account.logout', 'uses' => 'UserFrontController@logout'])->middleware('auth');


    Route::get('account/profile', ['as'=>'user.profile', 'uses'=>'UserFrontController@profile'])->middleware('auth');
    Route::get('account/change-password', 'UserFrontController@changePassword')->name('frontend.account.changepassword')->middleware('auth');
    Route::post('/change-password', 'UserFrontController@postPassword')->middleware('auth');
    Route::get('account/profile/edit', ['as'=>'edit.profile', 'uses'=>'UserFrontController@editprofile'])->middleware('auth');
    Route::post('account/profile/edit', ['as'=>'edit.profile', 'uses'=>'UserFrontController@posteditprofile'])->middleware('auth');

    Route::get('/account/password/reset', ['as'=>'user.password.email', 'uses'=>'UserFrontController@resetpassword']);
    Route::post('/account/password/reset', ['as'=>'user.password.email', 'uses'=>'UserFrontController@postresetpassword']);
    Route::get('/account/password/verify', ['as'=>'user.password.verify.reset', 'uses'=>'UserFrontController@verifyResetPassword']);

    Route::get('/account/verify/phone', ['as'=>'frontend.account.verifyphone', 'uses'=>'UserFrontController@verifyphone']);
    Route::post('/account/verify/phone', ['as'=>'frontend.account.verifyphone', 'uses'=>'UserFrontController@postverifyphone']);

    Route::get('/account/verify/document', ['as'=>'frontend.account.verifydocument', 'uses'=>'UserFrontController@verifydocument']);
    Route::post('/account/verify/document', ['as'=>'frontend.account.verifydocumente', 'uses'=>'UserFrontController@postverifydocument']);

});
