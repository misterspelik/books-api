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

/**
 * Routes without authentication
 */
Route::group(['middleware'=>['guest']], function () {
    Route::post('login', 'AuthController@login')->middleware('throttle:5,1');
});

Route::group(['middleware'=>['auth:api']], function () {
    Route::get('me', 'AuthController@me');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh-token', 'AuthController@refreshToken');

    Route::get('users', 'UsersController@index');
    Route::delete('users/delete', 'UsersController@delete');    

    Route::get('reports', 'ReportsController@index');
});
