<?php

$namespace = 'App\Modules\Ztest\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Ztest', 'namespace' => $namespace], function () {

});

Route::group(['middleware' => ['web'], 'module'=>'Ztest', 'namespace' => $namespace], function () {
    Route::get('/test/dacap', 'ZtestFrontController@dacap');

    Route::get('/test/votes','ZtestFrontController@getVotes');

    Route::post('/test/votes','ZtestFrontController@postVotes')->name('test.votes');


    Route::get('/product/votes','ZtestFrontController@getRating');

    Route::post('/product/vote','ZtestFrontController@postRating')->name('test.rating');
});
