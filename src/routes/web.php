<?php

Route::get('/', ['as' => 'better-log-viewer::log.index', 'uses' => 'LogViewerController@index']);
