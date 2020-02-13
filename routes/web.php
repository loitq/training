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
    //Route Admin
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ], function () {
        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('/users', 'AdminController@users')->name('admin.users');
    });

    //Route User
    Route::namespace('User')->group(function () {
        Route::get('/', 'UserController@index')->name('user.index');
        // route user's blog
        Route::get('/blog', 'BlogController@index')->name('blog.index');
        Route::post('/blog/stores', 'BlogController@store')->name('blog.store');
        Route::get('/blog/{id}/delete', 'BlogController@destroy')->name('blog.destroy');
        Route::get('/blog/{id}/edit', 'BlogController@edit')->name('blog.edit');
        Route::post('/blog/{id}/update', 'BlogController@update')->name('blog.update');
    });
});
