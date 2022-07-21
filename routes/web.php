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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/blogs/search', 'BlogController@search')->name('blogs.search');
    Route::resource('blogs', 'BlogController');

    Route::resource('users', 'UserController')->middleware('admin');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
