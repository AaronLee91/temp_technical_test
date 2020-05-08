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

Auth::routes(['verify' => true]);

Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/profile', 'UserController@update_profile_picture');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/articles', 'ArticleController@index');
Route::resource('articles', 'ArticleController');

Route::resource('comments', 'CommentsController')->except(['create','show']);
Route::get('/comments/create/{article}', 'CommentsController@create')->name('comments.create');
