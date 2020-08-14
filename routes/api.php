<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',

], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::get('userInfor', 'AuthController@getUserInfor');
    Route::post('updateInfor', 'AuthController@updateUserInfor');
    Route::post('createPost', 'PostController@createPost');
    Route::post('updatePost/{id}', 'PostController@updatePost');
    Route::delete('deletePost/{id}', 'PostController@deletePost');
    Route::get('/post', 'PostController@getAllPost');
    Route::get('/post/{id}', 'PostController@getSingle');
});