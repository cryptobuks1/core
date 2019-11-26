<?php

$namespace = 'App\Modules\Ticket\Controllers';
$as = config('backend.backendRoute');

Route::group(['prefix' => $as, 'middleware' => ['web','role:BACKEND'], 'module'=>'Ticket', 'namespace' => $namespace], function () {

    Route::get('tickets/{id}/view', ['as'=>'backend.ticket.view', 'uses'=>'TicketController@viewticket']);
    Route::post('tickets/reply', ['as'=>'backend.post.ticket.reply', 'uses'=>'TicketController@replyticket']);
    Route::resource('/tickets','TicketController');
});

//Frontend
Route::group(['middleware' => 'web', 'module'=>'Ticket', 'namespace' => $namespace], function () {

    Route::get('ticket/create', ['as'=>'frontend.send.request', 'uses'=>'TicketFrontController@index']);
    Route::post('send-request', ['as'=>'frontend.post.send.request', 'uses'=>'TicketFrontController@postrequest']);
});