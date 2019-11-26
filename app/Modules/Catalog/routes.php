<?php

$namespace = 'App\Modules\Catalog\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Catalog', 'namespace' => $namespace], function () {
    
    Route::resource('/catalogs','CatalogController');
});