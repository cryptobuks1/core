<?php

$namespace = 'App\Modules\Sendmail\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Sendmail', 'namespace' => $namespace], function () {
    Route::get('/sendmail', 'SendmailController@index');
    Route::get('/sendmail/test', 'SendmailController@sendmail');

    Route::get('sendmail/setting', ['as'=>'sendmail-setting', 'uses'=>'SendmailController@setting']);
    Route::patch('sendmail/setting', ['as'=>'sendmail-setting', 'uses'=>'SendmailController@postsetting']);
    Route::get('sendmail/install/{name}', ['as'=>'sendmail-install', 'uses'=>'SendmailController@install']);

    Route::get('sendmail/driver/{id}/update', ['as'=>'sendmail-driver-update', 'uses'=>'SendmailController@updatedriver']);
    Route::patch('sendmail/driver/{id}/update', ['as'=>'sendmail-driver-update', 'uses'=>'SendmailController@postupdatedriver']);

});