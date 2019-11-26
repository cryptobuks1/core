<?php

$namespace = 'App\Modules\Block\Controllers';
$as = config('backend.backendRoute');

//--FRONTEND
Route::group(['middleware' => ['web'], 'module'=>'Block', 'namespace' => $namespace], function () {

    Route::get('/blocks',['as'=>'frontend.blocks', 'uses'=> 'BlockFrontController@index']);
    Route::get('/showblock',['as'=>'frontend.showblock', 'uses'=> 'BlockFrontController@showblock']);

});


Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Block', 'namespace' => $namespace], function () {
    Route::patch('/blocks/{id}/createcontent',['as'=>'admin.blocks.contentcreate', 'uses'=> 'BlockController@postContent']);

    Route::get('/blocks/{id}/content',['as'=>'admin.blocks.content.index', 'uses'=> 'BlockController@blockContent']);
    Route::get('/blocks/content/create',['as'=>'admin.blocks.content.create', 'uses'=> 'BlockController@createContent']);
    Route::post('/blocks/content/create',['as'=>'admin.blocks.content.create', 'uses'=> 'BlockController@postContent']);
    Route::delete('/blocks/content/delete/{id}','BlockController@destroyContent');
    Route::resource('/blocks','BlockController');

});