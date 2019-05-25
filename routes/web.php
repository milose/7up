<?php

Route::get('/', 'PagesController@index');

Auth::routes();

Auth::routes();

Route::middleware(['auth'])
    ->namespace('Admin')
    ->group(function () {
        Route::get('/home', 'HomeController@index')->name('home');
    });
