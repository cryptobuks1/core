<?php

$namespace = 'App\Modules\Weblink\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Weblink', 'namespace' => $namespace], function () {
    
    Route::resource('/weblinks','WeblinkController');
});