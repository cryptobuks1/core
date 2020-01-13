<?php

$namespace = 'App\Modules\Tours\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Tours', 'namespace' => $namespace], function () {
    //Tour
    Route::group(['prefix'=>'tour'],  function () {
        Route::get('/',['as'=>'tour.index', 'uses'=> 'ToursController@index'] );
        Route::get('/create',['as'=>'tour.create', 'uses'=> 'ToursController@create'] );
        Route::post('/create',['as'=>'tour.store', 'uses'=> 'ToursController@store'] );
        Route::get('/edit/{id}',['as'=>'tour.edit', 'uses'=> 'ToursController@edit'] );
        Route::PATCH('/edit/{id}',['as'=>'tour.update', 'uses'=> 'ToursController@update'] );
        Route::delete('/delete/{id}',['as'=>'tour.destroy', 'uses'=> 'ToursController@destroy'] );
        Route::GET('/image/destroy/{id}',['as'=>'tour.image.delete', 'uses'=> 'ToursController@destroyImage'] );

        Route::get('/details/list/{id}',['as'=>'tour.details.list', 'uses'=> 'ToursController@detailsList'] );
        Route::get('/detail/edit/{id}',['as'=>'tour.details.edit', 'uses'=> 'ToursController@detailsEdit'] );
        Route::PATCH('/detail/edit/{id}',['as'=>'tour.details.update', 'uses'=> 'ToursController@detailsUpdate'] );
        Route::get('/detail/create/{id}',['as'=>'tour.details.create', 'uses'=> 'ToursController@detailCreate'] );
        Route::Post('/detail/create/{id}',['as'=>'tour.details.store', 'uses'=> 'ToursController@detailStore'] );
        Route::delete('/detail/delete/{id}',['as'=>'tour.details.delete', 'uses'=> 'ToursController@detailsDelete'] );

        Route::get('/schedules/{id}',['as'=>'tour.schedules.index', 'uses'=> 'ToursController@schedulesIndex'] );
        Route::get('/schedules/create/{id}',['as'=>'tour.schedules.create', 'uses'=> 'ToursController@schedulesCreate'] );
        Route::Post('/schedules/create/{id}',['as'=>'tour.schedules.store', 'uses'=> 'ToursController@schedulesStore'] );
        Route::delete('/schedules/delete/{id}',['as'=>'tour.schedules.delete', 'uses'=> 'ToursController@schedulesDelete'] );
        Route::get('/schedules/edit/{id}',['as'=>'tour.schedules.edit', 'uses'=> 'ToursController@schedulesEdit'] );
        Route::PATCH('/schedules/edit/{id}',['as'=>'tour.schedules.update', 'uses'=> 'ToursController@schedulesUpdate'] );




        //type
        Route::group(['prefix'=>'type'],  function () {
            Route::get('/',['as'=>'tour.type.index', 'uses'=> 'ToursController@indexType'] );
            Route::get('/create',['as'=>'tour.type.create', 'uses'=> 'ToursController@createType'] );
            Route::post('/create',['as'=>'tour.type.store', 'uses'=> 'ToursController@storeType'] );
            Route::get('/edit/{id}',['as'=>'tour.type.edit', 'uses'=> 'ToursController@editType'] );
            Route::PATCH('/update/{id}',['as'=>'tour.type.update', 'uses'=> 'ToursController@updateType'] );
            Route::delete('/delete/{id}',['as'=>'tour.type.destroy', 'uses'=> 'ToursController@destroyType'] );
        });
        //place
        Route::group(['prefix'=>'place'],  function () {
            Route::get('/',['as'=>'tour.place.index', 'uses'=> 'ToursController@indexPlace'] );
            Route::get('/create',['as'=>'tour.place.create', 'uses'=> 'ToursController@createPlace'] );
            Route::post('/create',['as'=>'tour.place.store', 'uses'=> 'ToursController@storePlace'] );
            Route::get('/edit/{id}',['as'=>'tour.place.edit', 'uses'=> 'ToursController@editPlace'] );
            Route::PATCH('/update/{id}',['as'=>'tour.place.update', 'uses'=> 'ToursController@updatePlace'] );
            Route::delete('/delete/{id}',['as'=>'tour.place.destroy', 'uses'=> 'ToursController@destroyPlace'] );

            Route::GET('/image/destroy/{id}',['as'=>'place.image.delete', 'uses'=> 'ToursController@destroyImagePlace'] );
        });
        //service
        Route::group(['prefix'=>'service'],  function () {
            Route::get('/',['as'=>'tour.service.index', 'uses'=> 'ToursController@indexService'] );
            Route::get('/create',['as'=>'tour.service.create', 'uses'=> 'ToursController@createService'] );
            Route::post('/create',['as'=>'tour.service.store', 'uses'=> 'ToursController@storeService'] );
            Route::get('/edit/{id}',['as'=>'tour.service.edit', 'uses'=> 'ToursController@editService'] );
            Route::PATCH('/update/{id}',['as'=>'tour.service.update', 'uses'=> 'ToursController@updateService'] );
            Route::delete('/delete/{id}',['as'=>'tour.service.destroy', 'uses'=> 'ToursController@destroyService'] );
        });

        //ajax
        Route::post('/ajax/tour/type',['as'=>'ajax.tour.type', 'uses'=> 'ToursController@ajaxTourType'] );
        Route::post('/ajax/tour/countries',['as'=>'ajax.tour.countries', 'uses'=> 'ToursController@ajaxCountries'] );
        Route::post('/ajax/tour/delete/images',['as'=>'ajax.tour.delimages', 'uses'=> 'ToursController@ajaxDeleteImages'] );

    });
});


Route::group(['middleware' => ['web'], 'module'=>'Tours', 'namespace' => $namespace], function () {
    Route::group(['prefix'=>'service'],  function () {

    });
});
