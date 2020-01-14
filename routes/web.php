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

Route::get('/admin/user/list', function () {
    return view('admin/user/list');
});

Route::get('admin/user/create', function () {
    return view('admin/user/create');
});

Route::get('/admin/user/edit', function () {
    return view('admin/user/edit');
});
