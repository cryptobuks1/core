<?php
$namespace = 'App\Modules\tiki\Controllers';
    //FrontEnd
Route::group(['middleware' =>['web'],'module'=>'tiki', 'namespace' => $namespace], function () {

    Route::group(['prefix'=>'tiki'],function (){


    });

});
$as = config('backend.backendRoute');
    //Trang admin
Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'tiki', 'namespace' => $namespace], function () {

    Route::group(['prefix'=>'tiki'],function (){
        Route::group(['prefix'=>'category'],function (){
            Route::get('/','CategoryController@index')->name('tiki.category');

            Route::get('/create','CategoryController@create');
            Route::post('/create','CategoryController@store')->name('tiki.category.create');

            Route::delete('/delete/{id}','CategoryController@destroy')->name('tiki.product.delete');

            Route::get('/edit/{id}','CategoryController@edit');
            Route::post('/edit/{id}','CategoryController@update')->name('tiki.category.update');

        });
    });

    Route::group(['prefix'=>'tiki'],function (){
        Route::group(['prefix'=>'product'],function (){
            Route::get('/','ProductController@index')->name('tiki.product');

            Route::delete('/delete/{id}','ProductController@destroy')->name('tiki.product.delete');

            Route::get('create','ProductController@create');
            Route::POST('create','ProductController@store')->name('tiki.product.create');
        });
    });

});






