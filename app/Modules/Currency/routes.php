<?php

$namespace = 'App\Modules\Currency\Controllers';

$as = config('backend.backendRoute');
Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Currency', 'namespace' => $namespace], function () {
    # User Modules
    Route::resource('currencies','CurrencyController');
    Route::post('currencies/actions','CurrencyController@actions');
});