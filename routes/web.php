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
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ], function () {
        // Controllers Within The "App\Http\Controllers\Admin" Namespace
        Route::get('/', 'AdminController@index')->name('admin.index');
        Route::get('/users', 'AdminController@users')->name('admin.users');
        Route::get('/blog', 'AdminBlogController@index')->name('admin.blog.index');
        Route::post('/blog/stores', 'AdminBlogController@store')->name('admin.blog.store');
        Route::get('/blog/{id}/delete', 'AdminBlogController@destroy')->name('admin.blog.destroy');
        Route::get('/blog/{id}/edit', 'AdminBlogController@edit')->name('admin.blog.edit');
        Route::post('/blog/{id}/update', 'AdminBlogController@update')->name('admin.blog.update');
    });

    //Route User
    Route::namespace('User')->group(function () {
        Route::get('/', 'BlogController@index')->name('blog.index');
        Route::post('/blog/stores', 'BlogController@store')->name('blog.store');
        Route::get('/blog/{id}/delete', 'BlogController@destroy')->name('blog.destroy');
        Route::get('/blog/{id}/edit', 'BlogController@edit')->name('blog.edit');
        Route::post('/blog/{id}/update', 'BlogController@update')->name('blog.update');
    });
});
