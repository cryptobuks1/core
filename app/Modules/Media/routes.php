<?php

$namespace = 'App\Modules\Media\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Media', 'namespace' => $namespace], function () {
    
    Route::get( 'medias', 'MediaController@index');

});