<?php

use Illuminate\Support\Facades\Route;
use Logviewer\Logviewer\Http\Controllers\LogViewerController;

Route::get('/log', function () {
    return 'Welcome';
});

Route::get('/log-package', function () {
    return 'Log package';
});

Route::get('/login', function () {
    return view('logviewer::login');
});

Route::post('/login-check', [LogViewerController::class, 'loginCheck']);

Route::group(['namespace' => 'Logviewer\Logviewer\Http\Controllers', 'middleware' => ['web', 'auth']], function () {
    Route::get('/log-viewer', 'LogViewerController@index');
    Route::post('/get-log-entries', 'LogViewerController@getLogEntries');
});
