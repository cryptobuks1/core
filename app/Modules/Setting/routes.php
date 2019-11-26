<?php

$namespace = 'App\Modules\Setting\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Setting', 'namespace' => $namespace], function () {

    Route::get('settings/general','SettingController@general');
    Route::post('settings/general', ['as'=>'admin.setttings.general','uses'=>'SettingController@update_general']);
    Route::post('settings/security', ['as'=>'admin.setttings.security','uses'=>'SettingController@update_security']);
    Route::post('settings/user', ['as'=>'admin.setttings.user','uses'=>'SettingController@update_user']);
    Route::post('settings/connection', ['as'=>'admin.setttings.connection','uses'=>'SettingController@update_connection']);
    Route::post('settings/design', ['as'=>'admin.setttings.design','uses'=>'SettingController@update_design']);

});