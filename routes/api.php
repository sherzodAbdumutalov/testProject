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
Route::post('login', 'Api\UserController@login');
Route::post('register', 'Api\UserController@register');

Route::middleware('auth:api')->group(function () {
    Route::get('user', 'Api\UserController@details');

    Route::resource('companies', 'Api\CompanyController');
    Route::get('/logout', 'Api\UserController@logout')->name('logout');

});