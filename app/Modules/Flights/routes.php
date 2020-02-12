<?php

$namespace = 'App\Modules\Flights\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Flights', 'namespace' => $namespace], function () {
    //Flights
    Route::group(['prefix'=>'flight'],  function () {
        Route::get('/',['as'=>'flight.index', 'uses'=> 'FlightsController@index'] );
        Route::get('/create',['as'=>'flight.create', 'uses'=> 'FlightsController@create'] );
        Route::post('/create',['as'=>'flight.store', 'uses'=> 'FlightsController@store'] );
        Route::get('/edit/{id}',['as'=>'flight.edit', 'uses'=> 'FlightsController@edit'] );
        Route::PATCH('/edit/{id}',['as'=>'flight.update', 'uses'=> 'FlightsController@update'] );
        Route::delete('/delete/{id}',['as'=>'flight.delete', 'uses'=> 'FlightsController@delete'] );


        Route::get('/search',['as'=>'flight.search', 'uses'=> 'FlightsController@search'] );
        Route::get('/search',['as'=>'flight.search', 'uses'=> 'FlightsController@search'] );
        Route::get('/checkin/{Session}/{FareDataId}/{FlightValue}',['as'=>'flight.get.checkin', 'uses'=> 'FlightsController@checkin'] );
        Route::post('/checkin/{id}',['as'=>'flight.post.checkin', 'uses'=> 'FlightsController@postCheckin'] );

        Route::get('/import',['as'=>'airline.get.import', 'uses'=> 'FlightsController@getImport'] );
        Route::post('/import',['as'=>'airline.import', 'uses'=> 'FlightsController@postImport'] );

        Route::group(['prefix'=>'api'],  function () {
            Route::post('/search',['as'=>'flight.api.search', 'uses'=> 'FlightsApi@postImport'] );
        });
    //Flight Routes
        Route::group(['prefix'=>'route'],  function () {
            Route::get('/',['as'=>'flight.route.index', 'uses'=> 'FlightsController@indexRoute'] );
            Route::get('/create',['as'=>'flight.route.create', 'uses'=> 'FlightsController@createRoute'] );
            Route::post('/create',['as'=>'flight.route.store', 'uses'=> 'FlightsController@storeRoute'] );
            Route::get('/edit/{id}',['as'=>'flight.route.edit', 'uses'=> 'FlightsController@editRoute'] );
            Route::PATCH('/edit/{id}',['as'=>'flight.route.update', 'uses'=> 'FlightsController@updateRoute'] );
            Route::delete('/delete/{id}',['as'=>'flight.route.delete', 'uses'=> 'FlightsController@deleteRoute'] );
        });

        //Flight Sations
        Route::group(['prefix'=>'station'],  function () {
            Route::get('/',['as'=>'flight.station.index', 'uses'=> 'FlightsController@indexStation'] );
            Route::get('/create',['as'=>'flight.station.create', 'uses'=> 'FlightsController@createStation'] );
            Route::post('/create',['as'=>'flight.station.store', 'uses'=> 'FlightsController@storeStation'] );
            Route::get('/edit/{id}',['as'=>'flight.station.edit', 'uses'=> 'FlightsController@editStation'] );
            Route::PATCH('/edit/{id}',['as'=>'flight.station.update', 'uses'=> 'FlightsController@updateStation'] );
            Route::delete('/delete/{id}',['as'=>'flight.station.delete', 'uses'=> 'FlightsController@deleteStation'] );
        });


        //Flight Airline
        Route::group(['prefix'=>'airline'],  function () {
            Route::get('/',['as'=>'flight.airline.index', 'uses'=> 'FlightsController@indexAirline'] );
            Route::get('/create',['as'=>'flight.airline.create', 'uses'=> 'FlightsController@createAirline'] );
            Route::post('/create',['as'=>'flight.airline.store', 'uses'=> 'FlightsController@storeAirline'] );
            Route::get('/edit/{id}',['as'=>'flight.airline.edit', 'uses'=> 'FlightsController@editAirline'] );
            Route::PATCH('/edit/{id}',['as'=>'flight.airline.update', 'uses'=> 'FlightsController@updateAirline'] );
            Route::delete('/delete/{id}',['as'=>'flight.airline.delete', 'uses'=> 'FlightsController@deleteAirline'] );
        });
    });
    Route::POST('/inventory/search/counties','FlightsController@ajaxCountries');
    Route::POST('/inventory/search/cities','FlightsController@ajaxCities')->name('ajax.flight.cities');
    Route::POST('/inventory/search/airline','FlightsController@ajaxAirline')->name('ajax.flight.airline');
    Route::POST('/inventory/search/departure','FlightsController@ajaxDeparture')->name('ajax.flight.departure');
    Route::POST('/inventory/search/arrival','FlightsController@ajaxArrival')->name('ajax.flight.arrival');
});


Route::group(['middleware' => ['web'], 'module'=>'Flights', 'namespace' => $namespace], function () {
    Route::get('/',['as'=>'front.flight.search3', 'uses'=> 'FlightsFrontController@search3'] );
    Route::group(['prefix'=>'flight'],  function () {
        Route::post('/list/',['as'=>'front.flight.list', 'uses'=> 'FlightsFrontController@list'] );
//        Route::get('/search3',['as'=>'front.flight.search', 'uses'=> 'FlightsFrontController@search'] );
//        Route::get('/search2',['as'=>'front.flight.search2', 'uses'=> 'FlightsFrontController@search2'] );
        Route::get('/checkin/{Session}/{FareDataId}/{FlightValue}',['as'=>'front.flight.get.checkin', 'uses'=> 'FlightsFrontController@checkin'] );
        Route::post('/checkin/{id}',['as'=>'front.flight.post.checkin', 'uses'=> 'FlightsFrontController@postCheckin'] );


        Route::POST('/inventory/search/counties','FlightsFrontController@ajaxCountries');
        Route::POST('/inventory/search/cities','FlightsFrontController@ajaxCities')->name('ajax.flight.cities2');
        Route::POST('/inventory/search/airline','FlightsFrontController@ajaxAirline')->name('ajax.flight.airline2');
        Route::POST('/inventory/search/departure','FlightsFrontController@ajaxDeparture')->name('ajax.flight.departure2');
        Route::POST('/inventory/search/arrival','FlightsFrontController@ajaxArrival')->name('ajax.flight.arrival2');
        Route::POST('/inventory/search/arrival2','FlightsFrontController@ajaxArrival2')->name('ajax.front.arrival');
        Route::GET('/api/test','FlightsApi@index');
    });
});
