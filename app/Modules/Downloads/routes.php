<?php



$namespace = 'App\Modules\Downloads\Controllers';

Route::group(['middleware' =>['web'],'module'=>'Downloads', 'namespace' => $namespace], function () {

    Route::get('/downloads/add','DownloadsFrontController@getCreateData');
    Route::post('/downloads/add','DownloadsFrontController@postCreateData')->name('download.add');

    Route::get('/downloadcat/add','DownloadsFrontController@getCreateDataCat');
    Route::post('/downloadcat/add','DownloadsFrontController@postCreateDataCat')->name('downloadcat.add');

    Route::get('/downloads','DownloadsFrontController@downloads')->name('downloads');

    Route::get('/downloadcat','DownloadsFrontController@downloadCat')->name('downloads.cat');

    Route::get('downloads/destroy/{id}','DownloadsFrontController@delete');

    Route::get('downloads/edit/{id}','DownloadsFrontController@edit')->name('downloads.edit');
    Route::post('downloads/edit/{id}','DownloadsFrontController@postEdit')->name('downloads.edit');
    Route::get('/file/destroy/{id}','DownloadsFrontController@destroyFile')->name('destroy.file');

    Route::get('downloads/product','DownloadsFrontController@product')->name('downloads.product');
    Route::get('downloads/detail/{id}','DownloadsFrontController@detail')->name('download.detail');

    Route::get('downloads/cart/add/{id}','CartController@getAddCart')->name('cart.add');
    Route::get('downloads/cart/show','CartController@index')->name('cart.index');
    Route::get('downloads/cart/delete/{rowId}','CartController@delete')->name('cart.delete');
    Route::get('downloads/cart/update','CartController@update')->name('cart.update');
    Route::post('downloads/cart/show','CartController@complete')->name('cart.complete');

});
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Downloads', 'namespace' => $namespace], function () {
   Route::get('downloads/danh-muc','DownloadsController@indexDanhMuc')->name('downnloads.danhmuc');
   Route::get('downloads','DownloadsController@index')->name('downnloads.index');

   Route::delete('/downloads/delete/{id}','DownloadsController@delete')->name('downloads.delete');

   Route::get('/downloads/edit/{id}','DownloadsController@getEditDownload');
   Route::post('downloads/edit/{id}','DownloadsController@postEditDownload')->name('download.edit');

   Route::delete('/file/delete/{id}','DownloadsController@deleteFile')->name('delete.file');
});






