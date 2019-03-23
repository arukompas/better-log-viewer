<?php

Route::get('css/{cache_breaker}/app.css', ['as' => 'better-log-viewer::assets.css', 'uses' => 'AssetController@css']);
Route::get('js/{cache_breaker}/app.js', ['as' => 'better-log-viewer::assets.js', 'uses' => 'AssetController@js']);
