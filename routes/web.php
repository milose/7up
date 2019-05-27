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
        Route::get('/nsfw', 'NsfwImagesController@index')->name('admin.nsfw.index');
        Route::get('/nsfw/{file}', 'NsfwImagesController@show')->name('admin.nsfw.show');
        Route::get('/nsfw/load/{file}', 'NsfwImageLoadController@show')->name('admin.nsfw.load');
    });

Route::post('/', 'FileController@store');
Route::get('/{file}', 'FileController@show');

// @TODO: Schedule an hourly job to clean up old files.
