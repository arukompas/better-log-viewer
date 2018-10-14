<?php

Route::get('/', 'LogViewerController@index')->name('better-log-viewer::log.index');

Route::get('test', function () {
    return 'hello from test!';
});