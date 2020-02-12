<?php

$namespace = 'App\Modules\News\Controllers';

$as = config('backend.backendRoute');
$middleware = ["web"];
if(env('LOGIN') === true){
    $middleware = ["web",'auth'];
}
Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'News', 'namespace' => $namespace], function () {

    Route::resource('news','NewsController');
    Route::post('news/actions','NewsController@actions');

});

//Frontend
Route::group(['middleware' => $middleware, 'module'=>'News', 'namespace' => $namespace], function () {
    Route::get('tin-tuc', ['as'=>'frontend.news.index', 'uses'=>'NewsFrontController@index']);
    Route::get('tin-tuc/{news_slug}', ['as'=>'frontend.news.view', 'uses'=>'NewsFrontController@renderViewPage']);
});