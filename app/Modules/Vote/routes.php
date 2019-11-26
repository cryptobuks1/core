<?php

$namespace = 'App\Modules\Vote\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Vote', 'namespace' => $namespace], function () {

});

Route::group(['middleware' => ['web','auth'], 'module'=>'Vote', 'namespace' => $namespace], function () {
    Route::get('/danh-gia.cs/sds','VoteFrontController@getRating');
    Route::post('/danh-gia','VoteFrontController@postRating')->name('front.post.rating');
    Route::post('ajax/like-vote','VoteFrontController@likeVote')->name('front.ajax.likevote');
    Route::post('/reply-comment','VoteFrontController@replyComment')->name('front.post.replycomment');
    Route::post('/product/vote','VoteFrontController@dannhgia')->name('test.rating');
});
