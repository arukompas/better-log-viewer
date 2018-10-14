<?php

Route::group(['prefix' => 'log'], function () {
    Route::get('files', 'LogsController@index')->name('better-log-viewer::api.logs.index');
    Route::get('file/{name}', 'LogsController@show')->name('better-log-viewer::api.logs.show');
});