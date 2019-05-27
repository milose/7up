<?php

Route::get('/', 'PagesController@index');

Auth::routes(['verify' => true]);

Route::middleware(['verified'])
    ->namespace('Verified')
    ->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });

Route::middleware(['verified', 'admin'])
    ->namespace('Admin')
    ->group(function () {
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    });

Route::post('/', 'FileController@store');
Route::get('/{file}', 'FileController@show');

// @TODO: Schedule an hourly job to clean up old files.
