<?php
    use Illuminate\Support\Facades\Route;

    Route::get('/log', function () {
        return'welcome';
    });
    Route::get('/log-package', function () {
        return'log package';
    });
    Route::group(['namespace'=>'Logviewer\Logviewer\Http\Controllers'],function(){
        Route::get('/log-viewer', 'LogViewerController@index');
        Route::post('/get-log-entries', 'LogViewerController@getLogEntries');
    });
