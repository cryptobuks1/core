<?php

$namespace = 'App\Modules\Upload\Controllers';

$as = config('backend.backendRoute');
Route::group(['middleware' => ['web'], 'module'=>'Backend', 'namespace' => $namespace], function () {
    Route::get('files/{hash}/{name}', 'UploadController@get_file');
});

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Upload', 'namespace' => $namespace], function () {
    
    # uploads Modules
    Route::get( 'uploads', 'UploadController@index');
    Route::post( 'uploads/upload_files', 'UploadController@upload_files');
    Route::get( 'uploads/uploaded_files', 'UploadController@uploaded_files');
    Route::post( 'uploads/uploads_update_caption', 'UploadController@update_caption');
    Route::post( 'uploads/uploads_update_filename', 'UploadController@update_filename');
    Route::post( 'uploads/uploads_update_public', 'UploadController@update_public');
    Route::post( 'uploads/uploads_delete_file', 'UploadController@delete_file');
});