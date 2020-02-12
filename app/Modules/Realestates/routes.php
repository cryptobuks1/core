<?php
$namespace = 'App\Modules\Realestates\Controllers';
    //FrontEnd
Route::group(['middleware' =>['web'],'module'=>'Realestates', 'namespace' => $namespace], function () {

    Route::group(['prefix'=>'realestates'],function () {
        //AJAX
        Route::post('/ajax','RealestatesFrontController@getAjaxCities')->name('ajax.cities');
        Route::post('/ajax/province','RealestatesFrontController@getAjaxProvince')->name('ajax.province');
        Route::post('/ajax/form','RealestatesFrontController@getAjaxForm')->name('ajax.form');
        Route::post('/ajax/v/form3','RealestatesFrontController@getAjaxForm3')->name('ajax.form3');
        Route::post('/ajax/time','RealestatesFrontController@ajaxTime')->name('ajax.time');
        Route::post('/ajax/time2','RealestatesFrontController@ajaxTime2')->name('ajax.time2');
        Route::post('/ajax/time2','RealestatesFrontController@ajaxTime2')->name('ajax.time2');

        Route::get('home','RealestatesFrontController@tinrao')->name('home');
        Route::get('/tin/{id}/{slug}','RealestatesFrontController@detail')->name('detail');
        Route::get('tin-noi-bat','RealestatesFrontController@featured')->name('tin.featured');
        Route::get('tin-moi','RealestatesFrontController@TinNews')->name('tin.news');

        Route::get('/nha-dat-ban','RealestatesFrontController@TinBan')->name('tin.ban');
        Route::get('/nha-dat-thue','RealestatesFrontController@TinThue')->name('tin.thue');

        Route::group(['prefix'=>'broker'],function () {
            Route::get('/', 'RealestatesFrontController@broker')->name('broker');
            Route::get('detail/{slug}/{id}','RealestatesFrontController@detailBroker')->name('broker.detail');
        });
    });
    //Trang tin rao
});
Route::group(['middleware' =>['web','auth'],'module'=>'Realestates', 'namespace' => $namespace], function () {
    Route::group(['prefix'=>'realestates'],function () {
        //Trang quả trị người dùng
        Route::get('index', 'RealestatesFrontController@index')->name('tin.rao');
        Route::get('create', 'RealestatesFrontController@create');
        Route::post('create', 'RealestatesFrontController@store')->name('tin.create');
        Route::get('edit/{id}', 'RealestatesFrontController@edit');
        Route::PATCH('edit/{id}', 'RealestatesFrontController@update')->name('tin.update');
        Route::delete('/delete/{id}', 'RealestatesFrontController@destroy')->name('tin.delete');
        Route::get('/img/delete/{id}', 'RealestatesFrontController@deleteImg')->name('tin.delete.img');

        //        Buy Vip
        Route::get('/vip/{id}/{slug}','RealestatesFrontController@BuyVip');
        Route::post('/vip/{id}/{slug}','RealestatesFrontController@postBuyVip')->name('tin.vip');

        //order
        Route::get('index/order/{order_code}', 'RealestatesFrontController@orderDetail')->name('tin.order');
        Route::get('listorder', 'RealestatesFrontController@listOrder')->name('tin.list.order');
        Route::delete('order/delete/{id}', 'RealestatesFrontController@deleteOrder')->name('tin.order.delete');

        Route::get('order/payment/{order_code}', 'PerfectMoneyController@SetExpressCheckout')->name('tin.payment');
        //broker
        Route::group(['prefix'=>'broker'],function () {
            Route::get('create','RealestatesFrontController@createBroker');
            Route::POST('create','RealestatesFrontController@postCreateBroker')->name('broker.create');
            Route::get('/edit/{id}','RealestatesFrontController@editBroker');
            Route::PATCH('/edit/{id}','RealestatesFrontController@postEditBroker')->name('broker.edit');
            Route::delete('/delete/{id}','RealestatesFrontController@deleteBroker')->name('broker.delete');
        });
    });

});
$as = config('backend.backendRoute');
    //Trang admin
Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Realestates', 'namespace' => $namespace], function () {
    Route::group(['prefix'=>'type'],function (){
        Route::get('index','RealestatesTypeController@index')->name('type.index');
        Route::get('create','RealestatesTypeController@create');
        Route::post('create','RealestatesTypeController@store')->name('type.create');
        Route::get('edit/{id}','RealestatesTypeController@edit');
        Route::PATCH('edit/{id}','RealestatesTypeController@update')->name('type.update');
        Route::delete('delete/{id}','RealestatesTypeController@destroy')->name('type.delete');
    });
    Route::group(['prefix'=>'realestates'],function (){
        Route::get('index','RealestatesController@index')->name('realestates');
        Route::get('edit/{id}','RealestatesController@edit');
        Route::PATCH('edit/{id}','RealestatesController@update')->name('realestates.update');
        Route::delete('delete/{id}','RealestatesController@destroy')->name('realestates.delete');
        Route::delete('img/delete/{id}','RealestatesController@deleteImg')->name('realestates.delete.img');
        Route::get('order','RealestatesController@order')->name('realestates.order');
        Route::delete('order/delete/{id}','RealestatesController@delete')->name('realestates.order.delete');
        Route::post('/ajax/form2','RealestatesController@getAjaxForm2')->name('ajax.form2');
    });
    Route::group(['prefix'=>'vip'],function () {
        Route::get('index','VipController@index')->name('vip.index');
        Route::get('create','VipController@create');
        Route::post('create','VipController@store')->name('vip.create');
        Route::get('edit/{id}','VipController@edit');
        Route::PATCH('edit/{id}','VipController@update')->name('vip.update');
        Route::delete('delete/{id}','VipController@destroy')->name('vip.destroy');
    });
    Route::group(['prefix'=>'group'],function () {
        Route::get('index','GroupProjectController@index')->name('group.index');
        Route::get('create','GroupProjectController@create');
        Route::post('create','GroupProjectController@store')->name('group.create');
        Route::get('edit/{id}','GroupProjectController@edit');
        Route::PATCH('edit/{id}','GroupProjectController@update')->name('group.update');
        Route::delete('delete/{id}','GroupProjectController@destroy')->name('group.destroy');
    });

    Route::group(['prefix'=>'project'],function () {
        Route::get('index','ProjectController@index')->name('project.index');
        Route::get('create','ProjectController@create');
        Route::post('create','ProjectController@store')->name('project.create');
        Route::get('edit/{id}','ProjectController@edit');
        Route::PATCH('edit/{id}','ProjectController@update')->name('project.update');
        Route::delete('delete/{id}','ProjectController@destroy')->name('project.destroy');
        Route::delete('/delete/file/{id}','ProjectController@delete')->name('project.delete');


    });

    Route::group(['prefix'=>'search'],function () {
        Route::get('index','SearchController@index')->name('search.index');
        Route::get('create','SearchController@create');
        Route::post('create','SearchController@store')->name('search.create');
        Route::get('edit/{id}','SearchController@edit');
        Route::PATCH('edit/{id}','SearchController@update')->name('search.update');
        Route::delete('delete/{id}','SearchController@destroy')->name('search.destroy');
    });

    Route::group(['prefix'=>'broker'],function () {
        Route::get('index','BrokerController@index')->name('broker.index');
        Route::get('edit/{id}','BrokerController@edit');
        Route::PATCH('edit/{id}','BrokerController@update')->name('broker.update');
        Route::delete('delete/{id}','BrokerController@destroy')->name('broker.delete');
    });
    });

Route::group(['middleware' =>['web'],'module'=>'Realestates', 'namespace' => $namespace], function () {
    Route::group(['prefix'=>'realestates'],function () {
        Route::get('/du-an','RealestatesFrontController@duan')->name('project.show');
        Route::get('/du-an/group/{slug}/{id}','RealestatesFrontController@GroupProject')->name('project.group');
        Route::get('/du-an/{slug}/{id}','RealestatesFrontController@DetailProject')->name('project.detail');
        Route::post('/ajax/project','RealestatesFrontController@ProjectCities')->name('ajax.project');
    });
});





