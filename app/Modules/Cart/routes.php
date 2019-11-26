<?php

$namespace = 'App\Modules\Shoppingcart\Controllers';
$as = config('backend.backendRoute');


//Frontend
Route::group(['middleware' => ['web'], 'module'=>'Shoppingcart', 'namespace' => $namespace], function () {
    Route::get('/viewcart.html',['as'=>'page.viewcart', 'uses'=> '\App\Modules\Frontend\Controllers\FrontendController@viewcart'] );
    Route::post('/addcart/{id}','ShoppingcartController@addcart');
});

Route::group(['prefix' => $as, 'middleware' => ['web','auth', 'role:BACKEND'], 'module'=>'Shoppingcart', 'namespace' => $namespace], function () {
    Route::get('/carthistory','ShoppingcartController@index');

});

