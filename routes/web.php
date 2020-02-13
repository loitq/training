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
        Route::get('/user/list', 'AdminController@userList')->name('admin.users');
        Route::get('/user/create', 'AdminController@userCreate')->name('admin.user.create');
        Route::post(
            '/user/create', 'AdminController@handleUserCreate'
        )->name('admin.user.handleCreate');
        Route::get('/user/edit/{id}', 'AdminController@userEdit')
        ->name('admin.user.update');
        Route::post(
            '/user/edit/{id}', 'AdminController@handleUserEdit'
        )->name('admin.user.handleUpdate');
        Route::get(
            '/user/delete/{id}', 'AdminController@handleDelete'
        )->name('admin.user.handleDelete');
        Route::get('/user/logout', 'AdminController@logout')
        ->name('admin.user.logout');
    });

    //Route User
    Route::namespace('User')->group(function () {
        Route::get('/', 'UserController@index')->name('user.index');
        Route::post('/comment/list', 'UserController@userListComment')->name('user.comment.list');
        Route::post('/comment/add', 'UserController@userAddComment')->name('user.comment.add');
        // route user's blog
        Route::get('/blog', 'BlogController@index')->name('blog.index');
        Route::post('/blog/stores', 'BlogController@store')->name('blog.store');
    });
});
