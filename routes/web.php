<?php

Route::get('/', 'PagesController@index');

Auth::routes();

Route::post('/', 'FileController@store');
Route::get('/{file}', 'FileController@show');

Route::middleware(['auth'])
    ->namespace('Admin')
    ->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });

// @TODO: Schedule an hourly job to clean up old files.
