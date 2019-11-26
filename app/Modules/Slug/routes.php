<?php

$namespace = 'App\Modules\Slug\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Slug', 'namespace' => $namespace], function () {
    Route::post('make/ajaxslug', 'SlugController@ajaxSlug');

});


