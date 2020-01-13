<?php

$namespace = 'App\Modules\Hotels\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Hotels', 'namespace' => $namespace], function () {
    //Tour
    Route::group(['prefix'=>'room'],  function () {
        Route::get('{hotel_id}/',['as'=>'room.index', 'uses'=> 'HotelsController@index'] );
        Route::get('/create/{hotel_id}',['as'=>'room.create', 'uses'=> 'HotelsController@create'] );
        Route::post('/create/{hotel_id}',['as'=>'room.store', 'uses'=> 'HotelsController@store'] );
        Route::get('/edit/{id}',['as'=>'room.edit', 'uses'=> 'HotelsController@edit'] );
        Route::PATCH('/edit/{id}',['as'=>'room.update', 'uses'=> 'HotelsController@update'] );
        Route::delete('/delete/{id}',['as'=>'room.delete', 'uses'=> 'HotelsController@delete'] );
        Route::GET('/image/destroy/{id}',['as'=>'room.image.delete', 'uses'=> 'HotelsController@destroyImage'] );
    });
    Route::group(['prefix'=>'hotel'],  function () {
        Route::get('/',['as'=>'hotel.index', 'uses'=> 'HotelsController@indexHotel'] );
        Route::get('/create',['as'=>'hotel.create', 'uses'=> 'HotelsController@createHotel'] );
        Route::post('/create',['as'=>'hotel.store', 'uses'=> 'HotelsController@storeHotel'] );
        Route::get('/edit/{id}',['as'=>'hotel.edit', 'uses'=> 'HotelsController@editHotel'] );
        Route::PATCH('/edit/{id}',['as'=>'hotel.update', 'uses'=> 'HotelsController@updateHotel'] );
        Route::delete('/delete/{id}',['as'=>'hotel.delete', 'uses'=> 'HotelsController@deleteHotel'] );
        Route::GET('/image/destroy/{id}',['as'=>'hotel.image.delete', 'uses'=> 'HotelsController@destroyImage'] );
    });
});


Route::group(['middleware' => ['web'], 'module'=>'Hotels', 'namespace' => $namespace], function () {
    Route::group(['prefix'=>'service'],  function () {

    });
});
