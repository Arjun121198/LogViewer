<?php
    use Illuminate\Support\Facades\Route;

    Route::get('/log', function () {
        return'welcome';
    });
    Route::get('/log-package', function () {
        return'log package';
    });
    Route::get('/login', function () {
        return view('logviewer::login');
    });
    Route::group(['namespace'=>'Logviewer\Logviewer\Http\Controllers'],function(){
        Route::post('/login-check', 'LogViewerController@loginCheck');
        Route::get('/log-viewer', 'LogViewerController@index');
        Route::post('/get-log-entries', 'LogViewerController@getLogEntries');
    });
