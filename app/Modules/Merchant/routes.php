<?php

$namespace = 'App\Modules\Merchant\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Merchant', 'namespace' => $namespace], function () {
    
    Route::resource('/merchants','MerchantController');
});