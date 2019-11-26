<?php

$namespace = 'App\Modules\Page\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Page', 'namespace' => $namespace], function () {

    Route::resource('pages','PageController');
    Route::post('pages/action','PageController@actions');

});

Route::group(['middleware' => ['web'], 'module'=>'Page', 'namespace' => $namespace], function () {

    Route::get('/p/{s_slug}','PageFrontController@viewpage')->name('frontend.staticpage.view');

});

