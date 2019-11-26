<?php

$namespace = 'App\Modules\Language\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Language', 'namespace' => $namespace], function () {

    Route::get('/language',['as'=>'backend.language.setting', 'uses'=> 'LanguageController@index'] );
    Route::get('/language/install/{code}',['as'=>'backend.language.install', 'uses'=> 'LanguageController@install'] );
    Route::get('/language/uninstall/{code}',['as'=>'backend.language.uninstall', 'uses'=> 'LanguageController@uninstall'] );
    Route::get('/language/{id}/update',['as'=>'backend.language.update', 'uses'=> 'LanguageController@updatelang'] );
    Route::patch('/language/{id}/update',['as'=>'backend.language.postupdate', 'uses'=> 'LanguageController@postupdatelang'] );

    Route::get('/language/files/{lang_code}',['as'=>'backend.language.files', 'uses'=> 'LanguageController@langFile']);
    Route::get('/language/translate/{filename}',['as'=>'backend.language.trans.filename', 'uses'=> 'LanguageController@translate']);
    Route::get('/language/import/{code}',['as'=>'backend.language.import.filename', 'uses'=> 'LanguageController@importlang']);
    Route::get('/language/reset/{code}',['as'=>'backend.language.reset.filename', 'uses'=> 'LanguageController@resetlang']);
    Route::get('/language/cache/{code}',['as'=>'backend.language.cache.filename', 'uses'=> 'LanguageController@cachelang']);
    Route::post('/language/ajax/translate',['as'=>'backend.language.ajax.translate', 'uses'=> 'LanguageController@updatetranslate']);


});

///Frontend
Route::group(['middleware' => ['web'], 'module'=>'Language', 'namespace' => $namespace], function () {

});
