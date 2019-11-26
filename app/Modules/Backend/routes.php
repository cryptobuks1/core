<?php

$namespace = 'App\Modules\Backend\Controllers';

$as = config('backend.backendRoute');


Route::group(['middleware' => ['web'], 'module'=>'Backend', 'namespace' => $namespace], function () {
    Route::get('files/{hash}/{name}', 'UploadsController@get_file');



});


Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Backend', 'namespace' => $namespace], function () {
    Route::post('/ajax', 'BackendController@ajaxActions');
    Route::get('/', 'BackendController@dashboard');
    Route::get('/ckfinderpopup', 'BackendController@ckfinderpopup');
    Route::get('/login-logs','BackendController@loginLogs');


    # Role Modules
    Route::resource('roles','RoleController');
    # Permission Modules
    Route::resource('permissions','PermissionController');
    Route::post('permissions/actions','PermissionController@actions');

    Route::post('getnotification','BackendController@ajaxGetNotification')->name('backend.ajaxgetnotification');
    # Webdata Modules
    Route::resource('webdata','WebdataController');
    Route::post('webdata/actions','WebdataController@actions');



});