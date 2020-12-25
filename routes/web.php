<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['prefix' => 'admin','namespace' => 'admin'], function () {
    Route::get('/dashboard','AdminController@dashboard');
    Ro