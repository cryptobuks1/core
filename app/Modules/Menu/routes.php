<?php

$namespace = 'App\Modules\Menu\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Menu', 'namespace' => $namespace], function () {
    Route::resource('menu','MenuController');
    Route::post('menu/ajaxPost','MenuController@ajaxPost')->name('menu.ajaxpost');
    Route::post('menu/ajaxItemAction','MenuController@ajaxItemAction')->name('menu.ajaxitemaction');
    Route::post('menu/renderCreateForm','MenuController@renderCreateForm')->name('menu.ajaxrenderform');
});