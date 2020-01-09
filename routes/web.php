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

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route Auth login
Route::get('/login', 'Auth\LoginController@show')->name('login')->middleware('guest');
Route::post('/login', 'Auth\LoginController@authenticate');

Route::middleware('auth')->group(function () {
    // Route Dashboard
    Route::get('/', 'DashboardController@index');
    
    // Route Auth
    Route::namespace('Auth')->group(function () {
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });
    
    //Route Admin
    Route::namespace('Admin')->group(function () {
        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::get('/', 'AdminController@index')->name('admin');
    });
});

