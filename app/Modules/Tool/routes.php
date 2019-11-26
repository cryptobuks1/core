<?php

$namespace = 'App\Modules\Tool\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Tool', 'namespace' => $namespace], function () {

    Route::get('/setmoney/{amount}',['as'=>'tool.tester', 'uses'=> 'ToolController@setmoney'] );
    Route::get('/countadminmoney',['as'=>'tool.count.money', 'uses'=> 'ToolController@countadminmoney'] );

    ///Xóa lịch sử của các bảng charging + order + wallethistory của nó.
    Route::get('/tools',['as'=>'tool.index', 'uses'=> 'ToolController@toolIndex'] );
    Route::post('/tools/delete-charging',['as'=>'tool.delete.charging', 'uses'=> 'ToolController@postdelCharging'] );
    Route::post('/tools/delete-mtopup',['as'=>'tool.delete.mtopup', 'uses'=> 'ToolController@postdelMtopup'] );
    Route::post('/tools/delete-order',['as'=>'tool.delete.order', 'uses'=> 'ToolController@postdelOrder']);
    Route::post('/tools/delete-trash',['as'=>'tool.delete.trash', 'uses'=> 'ToolController@postdelTrash']);
    Route::post('/tools/delete-user',['as'=>'tool.delete.user', 'uses'=> 'ToolController@postdelUser']);

    Route::get('/check-user-balance',['as'=>'check.user.balance', 'uses'=> 'ToolController@checkUserBalance'] );
    Route::get('/checkuserwallet/{wallet}',['as'=>'check.user.balance.w', 'uses'=> 'ToolController@checkuserwallet'] );
    Route::get('/database/export',['as'=>'database.export', 'uses'=> 'ToolController@exportdata'] );


});


Route::group(['middleware' => ['web'], 'module'=>'Tool', 'namespace' => $namespace], function () {


});
