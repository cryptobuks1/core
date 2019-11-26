<?php

$namespace = 'App\Modules\Group\Controllers';

$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'GroupProject', 'namespace' => $namespace], function () {
    # User Modules
    Route::resource('groups','GroupController');
    Route::post('groups/actions','GroupController@actions');
});
