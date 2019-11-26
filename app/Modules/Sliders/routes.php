<?php

$namespace = 'App\Modules\Sliders\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Sliders', 'namespace' => $namespace], function () {
    Route::resource('sliders','SlidersController');
    Route::post('sliders/actions','SlidersController@actions');
});