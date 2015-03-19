<?php

Route::get('/', 'HomeController@index');

Route::get('all', 'StatController@all');
Route::get('anomalies', function () {
    return View::make('anomalies');
});
Route::get('about', function () {
    return View::make('about');
});