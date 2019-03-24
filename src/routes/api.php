<?php

Route::get('files', ['as' => 'better-log-viewer::api.logs.index', 'uses' => 'LogsController@index']);
Route::get('file/{name}/download', ['as' => 'better-log-viewer::api.logs.download', 'uses' => 'LogsController@download']);
Route::delete('file/{name}', ['as' => 'better-log-viewer::api.logs.destroy', 'uses' => 'LogsController@destroy']);
Route::get('file/{name}', ['as' => 'better-log-viewer::api.logs.show', 'uses' => 'LogsController@show']);
