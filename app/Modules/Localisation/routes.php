<?php



$namespace = 'App\Modules\Localisation\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Localisation', 'namespace' => $namespace], function () {
    Route::get('/localisation/country/create','LocalisationController@getAddCountry')->name('addcountry');
    Route::post('/localisation/country/create','LocalisationController@postAddCountry');

    Route::get('/localisation/country/edit/{id}','LocalisationController@getEditCountry')->name('editcountry');
    Route::PATCH('/localisation/country/edit/{id}','LocalisationController@postEditCountry');

    Route::delete('/localisation/country/delete/{id}','LocalisationController@getDeleteCountry')->name('deletecountry');



    Route::get('/localisation/province/create','LocalisationController@getAddProvince')->name('addprovince');
    Route::post('/localisation/province/create','LocalisationController@postAddProvince');

    Route::get('/localisation/province/edit/{id}','LocalisationController@getEditProvince')->name('editprovince');
    Route::post('/localisation/province/edit/{id}','LocalisationController@postEditProvince');

    Route::delete('/localisation/province/delete/{id}','LocalisationController@getDeletProvince');



    Route::get('/localisation/city/create','LocalisationController@getAddCity')->name('addcity');
    Route::post('/localisation/city/create','LocalisationController@postAddCity');

    Route::get('/localisation/city/edit/{id}','LocalisationController@getEditCity')->name('editcities');
    Route::post('/localisation/city/edit/{id}','LocalisationController@postEditCity');

    Route::delete('/localisation/city/delete/{id}','LocalisationController@getDeletCity');



    Route::get('localisation/city','LocalisationController@getCity')->name('city');
    Route::get('localisation/country','LocalisationController@getCountry')->name('country');
    Route::get('localisation/provinces','LocalisationController@getProvince')->name('province');


//    Route::post('/admin/ajax-country','LocalisationController@getAjaxCountries')->name('ajax.countries');
//    Route::post('/admin/ajax-city','LocalisationController@getAjaxCities')->name('ajax.cities');
});

