<?php

$namespace = 'App\Modules\Tags\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Tags', 'namespace' => $namespace], function () {
    Route::resource('tagslist','TagslistController');
    Route::post('tagslist/actions','TagslistController@actions');

});

//Frontend
Route::group(['middleware' => ['web'], 'module'=>'Tags', 'namespace' => $namespace], function () {
    Route::get('tags/{code}', ['as'=>'frontend.tag.list', 'uses'=>'TaglistFrontController@tags']);

});
