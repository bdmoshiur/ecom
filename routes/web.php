<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'admin','namespace' => 'admin'], function () {
    Route::match(['get','post'],'/','AdminController@login')->name('admin.admin');
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/logout','AdminController@logout')->name('admin.logout');
        Route::get('/dashboard','AdminController@dashboard')->name('admin.dashboard');
    });

});


