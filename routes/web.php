<?php

Route::get('/', 'PagesController@index');

Auth::routes();

Route::middleware(['auth'])
    ->namespace('Admin')
    ->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });

Route::post('/', 'FileController@store');
Route::get('/{file}', 'FileController@show');

// @TODO: Schedule an hourly job to clean up old files.
