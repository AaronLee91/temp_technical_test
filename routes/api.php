<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Login & register
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

// Reset user password
Route::post('password/email', 'API\ForgotPasswordController@apiResetLinkEmail');
Route::post('password/reset', 'API\ResetPasswordController@reset');

Route::get('email/resend', 'API\VerificationController@resend')->name('verification.resend');
Route::get('email/verify/{id}/{hash}', 'API\VerificationController@verify')->name('verification.api_verify');

//Public API
Route::get('articles', 'API\ArticleController@index');
Route::get('articles/{article_id}', 'API\ArticleController@read_one');

// Authentication needed & only admin role
Route::group(['middleware' => ['auth:api', 'role:ROLE_ADMIN', 'verified.api']], function () {
    //Statistic related
    Route::get('statistics', 'API\StatisticsController@index');

    //User related
    Route::get('users', 'API\UserController@index');

    // Article related
    Route::post('articles/create', 'API\ArticleController@create');
    Route::put('articles/{article_id}', 'API\ArticleController@update');
    Route::delete('articles/{article_id}', 'API\ArticleController@delete');
});

// Authentication needed & both admin & user role
Route::group(['middleware' => ['auth:api', 'role:ROLE_USER|ROLE_ADMIN', 'verified.api']], function () {
    //User related
    Route::get('users/self', 'API\UserController@details');

    // Comment related
    Route::get('comments/{comment_id}', 'API\CommentsController@index');
    Route::post('articles/{article_id}/comment', 'API\CommentsController@create');
    Route::put('comments/{comment_id}', 'API\CommentsController@update');
    Route::delete('comments/{comment_id}', 'API\CommentsController@delete');
});

