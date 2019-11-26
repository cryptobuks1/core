<?php

$namespace = 'App\Modules\Price\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Price', 'namespace' => $namespace], function () {
    Route::get('/test',['as'=>'price.tester', 'uses'=> 'ApiController@test'] );


});


Route::group(['middleware' => ['web'], 'module'=>'Price', 'namespace' => $namespace], function () {

    Route::get('/api/callocta',['as'=>'price.tester2', 'uses'=> 'ApiFrontController@callocta'] );

});
