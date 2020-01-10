<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    // Route Dashboard
    Route::get('/', 'DashboardController@index');

    //Route Admin
    Route::namespace('Admin')->group(function () {
        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::get('/', 'AdminController@index')->name('admins.index');
    });

     //Route User
     Route::namespace('User')->group(function () {
        // Controllers Within The "App\Http\Controllers\User" Namespace
        Route::get('/', 'BlogController@index')->name('blogs.index');
    });
});

