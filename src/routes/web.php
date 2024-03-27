<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Logviewer\Logviewer\Http\Controllers\LogViewerController;

Route::get('/log', function () {
    return 'Welcome';
});

Route::get('/log-package', function () {
    return 'Log package';
});




Route::group(['namespace' => 'Logviewer\Logviewer\Http\Controllers', 'middleware' => [\Illuminate\Session\Middleware\StartSession::class
]], function () {
    Route::get('/login', function () {
        return view('logviewer::login');
    })->middleware('login');
    Route::get('/logout', 'LogViewerController@logout');
    Route::post('/login-check', 'LogViewerController@loginCheck');
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/log-viewer', 'LogViewerController@index');
        Route::post('/get-log-entries', 'LogViewerController@getLogEntries');
    });
});
