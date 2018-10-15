<?php

Route::get('files', ['as' => 'better-log-viewer::api.logs.index', 'uses' => 'LogsController@index']);
Route::get('file/{name}', ['as' => 'better-log-viewer::api.logs.show', 'uses' => 'LogsController@show']);
