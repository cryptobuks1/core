<?php

$namespace = 'App\Modules\Categories\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Menu', 'namespace' => $namespace], function () {
    Route::resource('categories','CategoriesController');
    Route::post('categories/ajaxPost','CategoriesController@ajaxPost')->name('categories.ajaxpost');
    Route::post('categories/ajaxItemAction','CategoriesController@ajaxItemAction')->name('categories.ajaxitemaction');
    Route::post('categories/renderCreateForm','CategoriesController@renderCreateForm')->name('categories.ajaxrenderform');
});