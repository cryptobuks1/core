<?php

$namespace = 'App\Modules\Seo\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Seo', 'namespace' => $namespace], function () {

    Route::resource('/seo','SeoController');

});


Route::group(['middleware' => ['web'], 'module'=>'Seo', 'namespace' => $namespace], function () {


});
