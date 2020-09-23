<?php

use Illuminate\Support\Facades\Route;

Route::namespace('\\App\\Http\\Controllers\\Users')
    ->prefix('auth')
    ->group(function () {
        Route::post('/login', 'AuthController@login')->name('auth.login');
        Route::get('/me', 'AuthController@me')->name('auth.me');
        Route::get('/refresh', 'AuthController@refresh')->name('auth.refresh');
        Route::get('/logout', 'AuthController@logout')->name('auth.logout');
    });
