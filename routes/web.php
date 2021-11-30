<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {

    Route::match(['get', 'post'], '/', 'AdminController@login')->name('admin.admin');

    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', 'AdminController@dashboard')->name('admin.dashboard');
        Route::get('settings', 'AdminController@settings')->name('admin.settings');
        Route::get('logout', 'AdminController@logout')->name('admin.logout');
        Route::post('check-current-password', 'AdminController@checkCurrentPassword')->name('admin.check.current.password');
        Route::post('update-current-password', 'AdminController@updateCurrentPassword')->name('admin.update.current.password');
        Route::match(['get', 'post'], 'update-admin-details', 'AdminController@updateAdminDetails')->name('admin.update.admin.details');

        //Sections
        Route::get('sections', 'SectionController@sections')->name('admin.sections');
        Route::post('/update-section-status', 'SectionController@updateSectionStatus');

        // Categories
        Route::get('categories', 'CategoryController@categories')->name('admin.categories');
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        Route::match(['get', 'post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory')->name('admin.add.edit.categories');

        Route::post('append-categories-lavel', 'CategoryController@appendCategoryLevel')->name('admin.append.category.level');
    });
});
