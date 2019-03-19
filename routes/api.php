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

Route::group(['namespace'=> 'Api'], function (){
    // 登录
    Route::post('authorizations', 'AuthorizationsController@store')
        ->name('api.authorizations.store');
    // 刷新token
    Route::put('authorizations/current', 'AuthorizationsController@update')
        ->name('api.authorizations.update');
    // 删除token
    Route::delete('authorizations/current', 'AuthorizationsController@destroy')
        ->name('api.authorizations.destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


